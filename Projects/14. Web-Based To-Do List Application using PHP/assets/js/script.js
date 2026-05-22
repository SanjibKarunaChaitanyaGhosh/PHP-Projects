async function api(action,data={}){

    const body = new URLSearchParams({
        action,
        ...data
    });

    const res = await fetch('api.php',{
        method:'POST',
        body
    });

    return res.json();
}

async function loadTasks(){

    const res = await fetch('api.php?action=list');

    const data = await res.json();

    const taskList = document.getElementById('taskList');

    taskList.innerHTML = '';

    data.tasks.forEach(task=>{

        taskList.innerHTML += `
        <div class="task ${task.done == 1 ? 'done':''}">
            <div>
                ${task.text}
                (${task.priority})
            </div>

            <div>

                <button onclick="toggleTask(${task.id})">
                    ✓
                </button>

                <button onclick="deleteTask(${task.id})">
                    X
                </button>

            </div>
        </div>
        `;
    });
}

async function addTask(){

    const text = document.getElementById('taskText').value;

    const priority = document.getElementById('priority').value;

    if(text==='') return;

    await api('add',{
        text,
        priority
    });

    document.getElementById('taskText').value='';

    loadTasks();
}

async function toggleTask(id){

    await api('toggle',{id});

    loadTasks();
}

async function deleteTask(id){

    await api('delete',{id});

    loadTasks();
}

loadTasks();