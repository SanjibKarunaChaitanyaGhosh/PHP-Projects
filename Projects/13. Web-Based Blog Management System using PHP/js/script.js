// ===============================
// MOBILE NAVBAR TOGGLE
// ===============================

const menuBtn = document.querySelector(".menu-btn");
const navLinks = document.querySelector(".nav-links");

if(menuBtn){

    menuBtn.addEventListener("click", () => {

        navLinks.classList.toggle("show");

    });

}


// ===============================
// DELETE CONFIRMATION
// ===============================

const deleteButtons = document.querySelectorAll(".delete-btn");

deleteButtons.forEach(button => {

    button.addEventListener("click", function(e){

        const confirmDelete = confirm(
            "Are you sure you want to delete this post?"
        );

        if(!confirmDelete){

            e.preventDefault();

        }

    });

});


// ===============================
// IMAGE PREVIEW BEFORE UPLOAD
// ===============================

const imageInput = document.querySelector("#imageInput");
const previewImage = document.querySelector("#previewImage");

if(imageInput){

    imageInput.addEventListener("change", function(){

        const file = this.files[0];

        if(file){

            const reader = new FileReader();

            reader.addEventListener("load", function(){

                previewImage.src = this.result;

                previewImage.style.display = "block";

            });

            reader.readAsDataURL(file);

        }

    });

}


// ===============================
// AUTO HIDE SUCCESS MESSAGE
// ===============================

const alertBox = document.querySelector(".alert");

if(alertBox){

    setTimeout(() => {

        alertBox.style.display = "none";

    }, 3000);

}


// ===============================
// SEARCH FILTER (LIVE SEARCH)
// ===============================

const searchInput = document.querySelector("#liveSearch");
const blogCards = document.querySelectorAll(".blog-card");

if(searchInput){

    searchInput.addEventListener("keyup", function(){

        const value = this.value.toLowerCase();

        blogCards.forEach(card => {

            const title = card.querySelector("h2").textContent.toLowerCase();

            if(title.includes(value)){

                card.style.display = "block";

            }else{

                card.style.display = "none";

            }

        });

    });

}