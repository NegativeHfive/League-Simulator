

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
    duration : 7,
    x:-300,
    opacity:0,
    ease:"power.out"
})

//varaible for the image 
let image = document.querySelector(".img");
gsap.from(image, {
  duration: 7,
  x: 300,
  opacity: 0,
  ease: "power.out",
});

//dit is om de bal te draaien
let footballIcon = document.querySelector(".football");
gsap.from(footballIcon, {
  duration: 3,
  rotation:360,
  repeat:-1,
  ease: "linear",
});

let sunnyIcon = document.querySelector(".podium");
gsap.from(sunnyIcon, {
  duration: 3,
  rotation: 360,
  repeat: -1,
  ease: "linear",
});
