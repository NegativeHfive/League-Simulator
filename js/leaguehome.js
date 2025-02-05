

let Titleh2 = document.querySelector(".league");

/*document.addEventListener("DOMContentLoaded", () => {
  gsap.to(Titleh2, {
    x: 300, // Moves 300px to the right
    duration: 1,
    ease: "power2.out",
  });
});*/


//variable for title
let title = document.querySelector(".title");
gsap.from(title,{
    duration : 3,
    x:-300,
    opacity:0,
    ease:"power.out"
})

//varaible for the image 
let image = document.querySelector(".img");
gsap.from(image, {
  duration: 3,
  x: 300,
  opacity: 0,
  ease: "power.out",
});
