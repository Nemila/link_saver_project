let profile_edit_btns = document.querySelectorAll(".profile_edit_btn");

for (let i = 0; i < profile_edit_btns.length; i++){
    profile_edit_btns[i].addEventListener('click', function () {
        let edit_form = document.querySelector(".edit_profile_form");
        edit_form.classList.toggle("is_hide");
    });
}