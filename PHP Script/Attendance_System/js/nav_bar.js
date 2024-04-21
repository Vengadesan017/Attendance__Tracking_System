// let arrow = document.querySelectorAll(".arrow");
// for (var i = 0; i < arrow.length; i++) {
//   arrow[i].addEventListener("click", (e)=>{
//     let arrowParent = e.target.parentElement.parentElement;
//     arrowParent.classList.toggle("showMenu");
//   });
// }





let sidebar = document.querySelector(".sidebar");
// sidebar.classList.remove("close"); // Remove the "close" class to show the sidebar by default
 if (window.matchMedia("(max-width: 800px)").matches) {
    // If viewport width is 800 pixels or less
    sidebar.classList.add("close"); // Add the "close" class
  } else {
    // If viewport width is greater than 768 pixels
    sidebar.classList.remove("close"); // Remove the "close" class
  }



let sidebarBtn = document.querySelector(".bx-menu");
sidebarBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("close"); // Toggle the "close" class instead of just adding it
});


