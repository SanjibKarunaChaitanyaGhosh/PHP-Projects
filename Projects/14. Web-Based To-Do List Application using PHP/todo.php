<?php
// ─── DB CONNECTION ──────────────────────────────────────────────────────────
$pdo = new PDO('mysql:host=localhost;dbname=taskr;charset=utf8mb4', 'root', '', [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

// ─── HELPERS ───────────────────────────────────────────────────────────────
function jsonRes(array $data): void {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function sanitize(string $s): string {
    return htmlspecialchars(trim($s), ENT_QUOTES, 'UTF-8');
}

// ─── AJAX ACTIONS ──────────────────────────────────────────────────────────
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    $text     = sanitize($_POST['text'] ?? '');
    $priority = in_array($_POST['priority'] ?? '', ['high','medium','low']) ? $_POST['priority'] : 'medium';
    if ($text === '') jsonRes(['ok' => false, 'msg' => 'Task text is required.']);
    $stmt = $pdo->prepare('INSERT INTO tasks (text, priority, created) VALUES (?, ?, ?)');
    $stmt->execute([$text, $priority, time()]);
    $id = (int)$pdo->lastInsertId();
    jsonRes(['ok' => true, 'task' => ['id' => $id, 'text' => $text, 'done' => false, 'priority' => $priority, 'created' => time()]]);
}

if ($action === 'toggle') {
    $id = (int)($_POST['id'] ?? 0);
    $pdo->prepare('UPDATE tasks SET done = NOT done WHERE id = ?')->execute([$id]);
    $done = (bool)$pdo->query("SELECT done FROM tasks WHERE id = $id")->fetchColumn();
    jsonRes(['ok' => true, 'done' => $done]);
}

if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    $pdo->prepare('DELETE FROM tasks WHERE id = ?')->execute([$id]);
    jsonRes(['ok' => true]);
}

if ($action === 'edit') {
    $id       = (int)($_POST['id'] ?? 0);
    $text     = sanitize($_POST['text'] ?? '');
    $priority = in_array($_POST['priority'] ?? '', ['high','medium','low']) ? $_POST['priority'] : 'medium';
    if ($text === '') jsonRes(['ok' => false, 'msg' => 'Task text is required.']);
    $pdo->prepare('UPDATE tasks SET text = ?, priority = ? WHERE id = ?')->execute([$text, $priority, $id]);
    jsonRes(['ok' => true, 'task' => ['id' => $id, 'text' => $text, 'priority' => $priority]]);
}

if ($action === 'clear_done') {
    $pdo->exec('DELETE FROM tasks WHERE done = 1');
    jsonRes(['ok' => true]);
}

if ($action === 'list') {
    $filter = $_GET['filter'] ?? 'all';
    $where  = match($filter) {
        'active'    => 'WHERE done = 0',
        'completed' => 'WHERE done = 1',
        default     => ''
    };
    $tasks = $pdo->query("SELECT * FROM tasks $where ORDER BY created DESC")->fetchAll();
    foreach ($tasks as &$t) { $t['done'] = (bool)$t['done']; $t['id'] = (int)$t['id']; }
    jsonRes(['ok' => true, 'tasks' => $tasks]);
}

// ─── STATS (inline for initial render) ────────────────────────────────────
$total  = (int)$pdo->query('SELECT COUNT(*) FROM tasks')->fetchColumn();
$done   = (int)$pdo->query('SELECT COUNT(*) FROM tasks WHERE done = 1')->fetchColumn();
$active = $total - $done;
$pct    = $total > 0 ? round(($done / $total) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TASKR — Task Manager</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Mono:ital,wght@0,300;0,400;0,500;1,400&family=Syne:wght@400;700;800&display=swap" rel="stylesheet">
<style>
/* ── RESET & TOKENS ─────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --bg:       #0d0d0d;
  --surface:  #141414;
  --border:   #2a2a2a;
  --border2:  #333;
  --text:     #e8e4dc;
  --muted:    #666;
  --accent:   #f0c040;
  --accent2:  #e05c3a;
  --green:    #4ecb71;
  --high:     #e05c3a;
  --med:      #f0c040;
  --low:      #4ecb71;
  --radius:   4px;
  --mono:     'DM Mono', monospace;
  --display:  'Syne', sans-serif;
}

html { scroll-behavior: smooth; }

body {
  background: var(--bg);
  color: var(--text);
  font-family: var(--mono);
  font-size: 14px;
  min-height: 100vh;
  line-height: 1.6;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
}

/* ── LAYOUT ─────────────────────────────────────────────── */
.wrapper {
  max-width: 780px;
  margin: 0 auto;
  padding: 40px 24px 80px;
}

/* ── HEADER ─────────────────────────────────────────────── */
header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  border-bottom: 2px solid var(--accent);
  padding-bottom: 20px;
  margin-bottom: 36px;
}

.logo {
  font-family: var(--display);
  font-size: 40px;
  font-weight: 800;
  letter-spacing: -2px;
  line-height: 1;
  color: var(--text);
}
.logo span { color: var(--accent); }

.header-meta {
  text-align: right;
  color: var(--muted);
  font-size: 11px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}
.header-meta strong {
  display: block;
  font-size: 24px;
  font-family: var(--display);
  font-weight: 700;
  color: var(--accent);
  letter-spacing: -1px;
  line-height: 1;
}

/* ── PROGRESS ───────────────────────────────────────────── */
.progress-wrap {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 16px 20px;
  margin-bottom: 28px;
  display: flex;
  align-items: center;
  gap: 20px;
}

.progress-bar-bg {
  flex: 1;
  height: 6px;
  background: var(--border);
  border-radius: 3px;
  overflow: hidden;
}
.progress-bar-fill {
  height: 100%;
  background: linear-gradient(90deg, var(--accent) 0%, var(--green) 100%);
  border-radius: 3px;
  transition: width 0.5s ease;
}

.progress-label {
  font-family: var(--display);
  font-size: 22px;
  font-weight: 700;
  color: var(--accent);
  white-space: nowrap;
  min-width: 56px;
  text-align: right;
}

.stats-row {
  display: flex;
  gap: 24px;
  font-size: 11px;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.08em;
}
.stats-row span b { color: var(--text); }

/* ── ADD FORM ───────────────────────────────────────────── */
.add-form {
  display: flex;
  gap: 10px;
  margin-bottom: 28px;
  align-items: stretch;
}

.add-form input[type="text"] {
  flex: 1;
  background: var(--surface);
  border: 1px solid var(--border2);
  border-radius: var(--radius);
  color: var(--text);
  font-family: var(--mono);
  font-size: 14px;
  padding: 12px 16px;
  outline: none;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.add-form input[type="text"]:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 3px rgba(240,192,64,0.12);
}
.add-form input[type="text"]::placeholder { color: var(--muted); }

.priority-select {
  background: var(--surface);
  border: 1px solid var(--border2);
  border-radius: var(--radius);
  color: var(--text);
  font-family: var(--mono);
  font-size: 12px;
  padding: 0 14px;
  outline: none;
  cursor: pointer;
  transition: border-color 0.2s;
  appearance: none;
  min-width: 100px;
  text-transform: uppercase;
  letter-spacing: 0.06em;
}
.priority-select:focus { border-color: var(--accent); }

.btn-add {
  background: var(--accent);
  color: #000;
  border: none;
  border-radius: var(--radius);
  font-family: var(--display);
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  padding: 0 22px;
  cursor: pointer;
  transition: background 0.15s, transform 0.1s;
  white-space: nowrap;
}
.btn-add:hover  { background: #f8d060; }
.btn-add:active { transform: scale(0.97); }

/* ── FILTER TABS ─────────────────────────────────────────── */
.filter-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 18px;
}

.filter-tabs {
  display: flex;
  gap: 2px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 3px;
}
.filter-tab {
  font-family: var(--mono);
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  padding: 6px 14px;
  border-radius: 2px;
  border: none;
  background: none;
  color: var(--muted);
  cursor: pointer;
  transition: background 0.15s, color 0.15s;
}
.filter-tab.active, .filter-tab:hover {
  background: var(--border2);
  color: var(--text);
}
.filter-tab.active { color: var(--accent); }

.btn-clear {
  font-family: var(--mono);
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  padding: 6px 14px;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  background: none;
  color: var(--muted);
  cursor: pointer;
  transition: border-color 0.15s, color 0.15s;
}
.btn-clear:hover { border-color: var(--accent2); color: var(--accent2); }

/* ── TASK LIST ───────────────────────────────────────────── */
#task-list { display: flex; flex-direction: column; gap: 8px; }

.task-item {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px 16px;
  transition: border-color 0.2s, opacity 0.3s, transform 0.3s;
  position: relative;
  overflow: hidden;
}
.task-item::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 3px;
}
.task-item.p-high::before   { background: var(--high); }
.task-item.p-medium::before { background: var(--med); }
.task-item.p-low::before    { background: var(--low); }

.task-item:hover { border-color: var(--border2); }
.task-item.done  { opacity: 0.45; }

.task-item.entering {
  animation: slideIn 0.3s ease forwards;
}
@keyframes slideIn {
  from { opacity: 0; transform: translateY(-12px); }
  to   { opacity: 1; transform: translateY(0); }
}
.task-item.removing {
  animation: slideOut 0.25s ease forwards;
}
@keyframes slideOut {
  to { opacity: 0; transform: translateX(30px); }
}

/* Checkbox */
.task-check {
  width: 20px; height: 20px;
  border: 2px solid var(--border2);
  border-radius: 3px;
  cursor: pointer;
  flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  transition: border-color 0.15s, background 0.15s;
  position: relative;
}
.task-check:hover  { border-color: var(--accent); }
.task-check.checked { background: var(--green); border-color: var(--green); }
.task-check.checked::after {
  content: '';
  width: 5px; height: 9px;
  border: 2px solid #000;
  border-top: none; border-left: none;
  transform: rotate(45deg) translateY(-1px);
  display: block;
}

/* Task text */
.task-text {
  flex: 1;
  font-size: 14px;
  transition: text-decoration 0.2s;
}
.task-item.done .task-text {
  text-decoration: line-through;
  color: var(--muted);
}

.task-meta {
  font-size: 10px;
  color: var(--muted);
  letter-spacing: 0.05em;
  white-space: nowrap;
}

/* Priority badge */
.p-badge {
  font-size: 9px;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  padding: 2px 8px;
  border-radius: 2px;
  font-weight: 500;
}
.p-badge.high   { background: rgba(224,92,58,0.15);  color: var(--high); }
.p-badge.medium { background: rgba(240,192,64,0.15); color: var(--med); }
.p-badge.low    { background: rgba(78,203,113,0.15); color: var(--low); }

/* Action buttons */
.task-actions { display: flex; gap: 6px; opacity: 0; transition: opacity 0.15s; }
.task-item:hover .task-actions { opacity: 1; }

.btn-icon {
  width: 28px; height: 28px;
  background: none;
  border: 1px solid var(--border);
  border-radius: 3px;
  color: var(--muted);
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px;
  transition: border-color 0.15s, color 0.15s, background 0.15s;
}
.btn-icon:hover { border-color: var(--border2); color: var(--text); }
.btn-icon.delete:hover { border-color: var(--accent2); color: var(--accent2); background: rgba(224,92,58,0.08); }
.btn-icon.edit:hover   { border-color: var(--accent);  color: var(--accent);  background: rgba(240,192,64,0.08); }

/* ── EDIT MODAL ──────────────────────────────────────────── */
.modal-backdrop {
  position: fixed; inset: 0;
  background: rgba(0,0,0,0.75);
  display: flex; align-items: center; justify-content: center;
  z-index: 100;
  opacity: 0; pointer-events: none;
  transition: opacity 0.2s;
}
.modal-backdrop.open { opacity: 1; pointer-events: all; }

.modal {
  background: var(--surface);
  border: 1px solid var(--border2);
  border-top: 3px solid var(--accent);
  border-radius: var(--radius);
  padding: 28px 28px 24px;
  width: min(480px, 90vw);
  transform: translateY(20px);
  transition: transform 0.25s;
}
.modal-backdrop.open .modal { transform: translateY(0); }

.modal h2 {
  font-family: var(--display);
  font-size: 18px;
  font-weight: 700;
  letter-spacing: -0.5px;
  margin-bottom: 18px;
  color: var(--text);
}
.modal label {
  display: block;
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--muted);
  margin-bottom: 6px;
}
.modal input[type="text"],
.modal select {
  width: 100%;
  background: var(--bg);
  border: 1px solid var(--border2);
  border-radius: var(--radius);
  color: var(--text);
  font-family: var(--mono);
  font-size: 14px;
  padding: 10px 14px;
  margin-bottom: 16px;
  outline: none;
  transition: border-color 0.2s;
  appearance: none;
}
.modal input[type="text"]:focus,
.modal select:focus { border-color: var(--accent); }

.modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 6px; }

.btn-cancel {
  background: none; border: 1px solid var(--border);
  color: var(--muted); font-family: var(--mono);
  font-size: 12px; text-transform: uppercase; letter-spacing: 0.08em;
  padding: 9px 18px; border-radius: var(--radius); cursor: pointer;
  transition: border-color 0.15s, color 0.15s;
}
.btn-cancel:hover { border-color: var(--border2); color: var(--text); }

.btn-save {
  background: var(--accent); border: none;
  color: #000; font-family: var(--display);
  font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em;
  padding: 9px 20px; border-radius: var(--radius); cursor: pointer;
  transition: background 0.15s;
}
.btn-save:hover { background: #f8d060; }

/* ── EMPTY STATE ─────────────────────────────────────────── */
.empty {
  text-align: center;
  padding: 60px 0;
  color: var(--muted);
}
.empty-icon { font-size: 36px; margin-bottom: 12px; }
.empty p    { font-size: 12px; text-transform: uppercase; letter-spacing: 0.1em; }

/* ── TOAST ───────────────────────────────────────────────── */
#toast {
  position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%) translateY(20px);
  background: var(--surface); border: 1px solid var(--border2);
  border-left: 3px solid var(--green);
  color: var(--text); font-family: var(--mono); font-size: 12px;
  padding: 10px 20px; border-radius: var(--radius);
  opacity: 0; pointer-events: none;
  transition: opacity 0.25s, transform 0.25s;
  z-index: 200; white-space: nowrap;
}
#toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

/* ── FOOTER ──────────────────────────────────────────────── */
footer {
  margin-top: 48px;
  border-top: 1px solid var(--border);
  padding-top: 16px;
  display: flex; justify-content: space-between;
  font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted);
}

/* ── RESPONSIVE ──────────────────────────────────────────── */
@media (max-width: 520px) {
  .add-form { flex-wrap: wrap; }
  .add-form input[type="text"] { flex-basis: 100%; }
  .priority-select, .btn-add { flex: 1; }
}
</style>
</head>
<body>
<div class="wrapper">

  <!-- HEADER -->
  <header>
    <div class="logo">TASK<span>R</span></div>
    <div class="header-meta">
      <strong id="stat-active"><?= $active ?></strong>
      tasks remaining
    </div>
  </header>

  <!-- PROGRESS -->
  <div class="progress-wrap">
    <div class="stats-row">
      <span><b id="stat-total"><?= $total ?></b> total</span>
      <span><b id="stat-done"><?= $done ?></b> done</span>
    </div>
    <div class="progress-bar-bg">
      <div class="progress-bar-fill" id="progress-fill" style="width:<?= $pct ?>%"></div>
    </div>
    <div class="progress-label" id="progress-pct"><?= $pct ?>%</div>
  </div>

  <!-- ADD FORM -->
  <div class="add-form">
    <input type="text" id="new-task-text" placeholder="What needs to be done?" autocomplete="off" maxlength="200">
    <select class="priority-select" id="new-priority">
      <option value="high">▲ High</option>
      <option value="medium" selected>◆ Medium</option>
      <option value="low">▼ Low</option>
    </select>
    <button class="btn-add" onclick="addTask()">+ Add</button>
  </div>

  <!-- FILTER BAR -->
  <div class="filter-bar">
    <div class="filter-tabs">
      <button class="filter-tab active" data-filter="all"       onclick="setFilter(this,'all')">All</button>
      <button class="filter-tab"        data-filter="active"    onclick="setFilter(this,'active')">Active</button>
      <button class="filter-tab"        data-filter="completed" onclick="setFilter(this,'completed')">Done</button>
    </div>
    <button class="btn-clear" onclick="clearDone()">Clear completed</button>
  </div>

  <!-- TASK LIST -->
  <div id="task-list"></div>

</div><!-- /wrapper -->

<!-- EDIT MODAL -->
<div class="modal-backdrop" id="modal-backdrop" onclick="closeModal(event)">
  <div class="modal">
    <h2>Edit Task</h2>
    <label>Task</label>
    <input type="text" id="edit-text" maxlength="200">
    <label>Priority</label>
    <select id="edit-priority">
      <option value="high">▲ High</option>
      <option value="medium">◆ Medium</option>
      <option value="low">▼ Low</option>
    </select>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal()">Cancel</button>
      <button class="btn-save"   onclick="saveEdit()">Save</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div id="toast"></div>

<!-- FOOTER -->
<div class="wrapper" style="padding-top:0">
  <footer>
    <span>TASKR — MySQL Edition</span>
    <span><?= date('Y-m-d') ?></span>
  </footer>
</div>

<script>
// ── STATE ─────────────────────────────────────────────────
let currentFilter = 'all';
let editingId     = null;

// ── INIT ──────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  loadTasks();
  document.getElementById('new-task-text').addEventListener('keydown', e => {
    if (e.key === 'Enter') addTask();
  });
  document.getElementById('edit-text').addEventListener('keydown', e => {
    if (e.key === 'Enter') saveEdit();
    if (e.key === 'Escape') closeModal();
  });
});

// ── API CALL ──────────────────────────────────────────────
async function api(action, data = {}) {
  const body = new URLSearchParams({ action, ...data });
  const res  = await fetch(window.location.pathname, { method: 'POST', body });
  return res.json();
}
async function apiGet(params = {}) {
  const qs  = new URLSearchParams(params).toString();
  const res = await fetch(window.location.pathname + '?' + qs);
  return res.json();
}

// ── LOAD TASKS ────────────────────────────────────────────
async function loadTasks(animate = false) {
  const data = await apiGet({ action: 'list', filter: currentFilter });
  renderTasks(data.tasks, animate);
  updateStats();
}

// ── RENDER ────────────────────────────────────────────────
function renderTasks(tasks, animate) {
  const list = document.getElementById('task-list');

  if (!tasks || tasks.length === 0) {
    list.innerHTML = `
      <div class="empty">
        <div class="empty-icon">✓</div>
        <p>${currentFilter === 'completed' ? 'No completed tasks yet' :
            currentFilter === 'active'    ? 'All done! Nice work.' :
                                           'No tasks yet — add one above'}</p>
      </div>`;
    return;
  }

  list.innerHTML = tasks.map(t => taskHTML(t)).join('');
  if (animate) {
    list.querySelectorAll('.task-item').forEach((el, i) => {
      el.style.animationDelay = (i * 40) + 'ms';
      el.classList.add('entering');
    });
  }
}

function taskHTML(t) {
  const age = timeAgo(t.created);
  return `
  <div class="task-item p-${t.priority} ${t.done ? 'done' : ''}" id="task-${t.id}">
    <div class="task-check ${t.done ? 'checked' : ''}" onclick="toggleTask(${t.id})"></div>
    <div class="task-text">${escHtml(t.text)}</div>
    <span class="p-badge ${t.priority}">${t.priority}</span>
    <div class="task-meta">${age}</div>
    <div class="task-actions">
      <button class="btn-icon edit"   title="Edit"   onclick="openEdit(${t.id},'${escAttr(t.text)}','${t.priority}')">✎</button>
      <button class="btn-icon delete" title="Delete" onclick="deleteTask(${t.id})">✕</button>
    </div>
  </div>`;
}

// ── ACTIONS ───────────────────────────────────────────────
async function addTask() {
  const input    = document.getElementById('new-task-text');
  const priority = document.getElementById('new-priority').value;
  const text     = input.value.trim();
  if (!text) { input.focus(); return; }

  const data = await api('add', { text, priority });
  if (!data.ok) { toast(data.msg, 'error'); return; }

  input.value = '';
  input.focus();
  await loadTasks();
  const el = document.getElementById('task-' + data.task.id);
  if (el) el.classList.add('entering');
  toast('Task added');
}

async function toggleTask(id) {
  await api('toggle', { id });
  const item  = document.getElementById('task-' + id);
  const check = item?.querySelector('.task-check');
  if (item)  item.classList.toggle('done');
  if (check) check.classList.toggle('checked');
  updateStats();
}

async function deleteTask(id) {
  const item = document.getElementById('task-' + id);
  if (item) {
    item.classList.add('removing');
    await new Promise(r => setTimeout(r, 230));
  }
  await api('delete', { id });
  await loadTasks();
  toast('Task deleted');
}

async function clearDone() {
  await api('clear_done');
  await loadTasks(true);
  toast('Completed tasks cleared');
}

// ── FILTER ────────────────────────────────────────────────
function setFilter(btn, filter) {
  currentFilter = filter;
  document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  loadTasks(true);
}

// ── EDIT MODAL ────────────────────────────────────────────
function openEdit(id, text, priority) {
  editingId = id;
  document.getElementById('edit-text').value     = text;
  document.getElementById('edit-priority').value = priority;
  document.getElementById('modal-backdrop').classList.add('open');
  setTimeout(() => document.getElementById('edit-text').focus(), 100);
}

function closeModal(e) {
  if (e && e.target !== document.getElementById('modal-backdrop')) return;
  document.getElementById('modal-backdrop').classList.remove('open');
  editingId = null;
}

async function saveEdit() {
  if (!editingId) return;
  const text     = document.getElementById('edit-text').value.trim();
  const priority = document.getElementById('edit-priority').value;
  if (!text) return;

  const data = await api('edit', { id: editingId, text, priority });
  if (!data.ok) { toast(data.msg, 'error'); return; }

  document.getElementById('modal-backdrop').classList.remove('open');
  editingId = null;
  await loadTasks();
  toast('Task updated');
}

// ── STATS ─────────────────────────────────────────────────
async function updateStats() {
  const data  = await apiGet({ action: 'list', filter: 'all' });
  const tasks  = data.tasks || [];
  const total  = tasks.length;
  const done   = tasks.filter(t => t.done).length;
  const active = total - done;
  const pct    = total > 0 ? Math.round((done / total) * 100) : 0;

  document.getElementById('stat-total').textContent   = total;
  document.getElementById('stat-done').textContent    = done;
  document.getElementById('stat-active').textContent  = active;
  document.getElementById('progress-fill').style.width = pct + '%';
  document.getElementById('progress-pct').textContent  = pct + '%';
}

// ── TOAST ─────────────────────────────────────────────────
let _toastTimer;
function toast(msg, type = 'ok') {
  const el = document.getElementById('toast');
  el.textContent = msg;
  el.style.borderLeftColor = type === 'error' ? 'var(--high)' : 'var(--green)';
  el.classList.add('show');
  clearTimeout(_toastTimer);
  _toastTimer = setTimeout(() => el.classList.remove('show'), 2500);
}

// ── HELPERS ───────────────────────────────────────────────
function escHtml(s) {
  return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function escAttr(s) {
  return s.replace(/'/g,"\\'").replace(/"/g,'&quot;');
}
function timeAgo(ts) {
  const diff = Math.floor(Date.now() / 1000) - ts;
  if (diff < 60)    return 'just now';
  if (diff < 3600)  return Math.floor(diff / 60)   + 'm ago';
  if (diff < 86400) return Math.floor(diff / 3600)  + 'h ago';
  return Math.floor(diff / 86400) + 'd ago';
}
</script>
</body>
</html>
