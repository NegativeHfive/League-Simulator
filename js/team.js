document.querySelector(".editlink").addEventListener("click", function (event) {
  event.preventDefault(); // dit voorkomt onnmeiddelijk

  gsap.to("body", {
    opacity: 0,
    duration: 0.8,
    onComplete: () => {
      window.location.href = event.target.href;
    },
  });
});

document.addEventListener("DOMContentLoaded", () => {
  gsap.fromTo("body", { opacity: 0 }, { opacity: 1, duration: 1 });
});


document.addEventListener("DOMContentLoaded", () => {
  const teamRows = document.querySelectorAll(".fade");

  // Fade in each row with a small delay to create a cascading effect
  teamRows.forEach((row, index) => {
    gsap.fromTo(
      row,
      { opacity: 0 },
      { opacity: 1, duration:0.8, delay: index * 0.8 }
    );
  });
});
