document.addEventListener("DOMContentLoaded", function () {
  let audio = document.getElementById("bgMusic");

  // Check if the audio is already playing (from Local Storage)
  let savedTime = localStorage.getItem("musicTime") || 0;
  let isPlaying = localStorage.getItem("musicPlaying") === "true";

  audio.currentTime = savedTime; // Restore previous position
  if (isPlaying) {
    audio.play();
  }

  // Save progress before navigating away
  window.addEventListener("beforeunload", function () {
    localStorage.setItem("musicTime", audio.currentTime);
    localStorage.setItem("musicPlaying", !audio.paused);
  });
});
