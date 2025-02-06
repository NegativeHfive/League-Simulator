

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
    duration : 2,
    x:-300,
    opacity:0,
    ease:"power.out"
})

//varaible for the image 
let image = document.querySelector(".img");
gsap.from(image, {
  duration: 2,
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


let dataIcon = document.querySelector(".document");
gsap.to(dataIcon, {
  duration: 1.5,
  y: -20, // Moves up by 20px
  repeat: -1,
  yoyo: true, // Moves back and forth
  ease: "sine.inOut",
});


document.querySelector(".play").addEventListener("click",function (event){
  event.preventDefault(); // dit voorkomt onnmeiddelijk

  gsap.to("body",{
    opacity:0,
    duration:0.8,
    onComplete:()=>{
      window.location.href = event.target.href;
    }
  })
})

document.querySelector(".homelink").addEventListener("click", function (event) {
  event.preventDefault(); // dit voorkomt onnmeiddelijk

  gsap.to("body", {
    opacity: 0,
    duration: 0.8,
    onComplete: () => {
      window.location.href = event.target.href;
    },
  });
});

document.querySelector(".aboutmelink").addEventListener("click", function (event) {
  event.preventDefault(); // dit voorkomt onnmeiddelijk

  gsap.to("body", {
    opacity: 0,
    duration: 0.8,
    onComplete: () => {
      window.location.href = event.target.href;
    },
  });
});

document.querySelector(".helplink").addEventListener("click", function (event) {
  event.preventDefault(); // dit voorkomt onnmeiddelijk

  gsap.to("body", {
    opacity: 0,
    duration: 0.8,
    onComplete: () => {
      window.location.href = event.target.href;
    },
  });
});

