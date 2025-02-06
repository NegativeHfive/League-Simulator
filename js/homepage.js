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
