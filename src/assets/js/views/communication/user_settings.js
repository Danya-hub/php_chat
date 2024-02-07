"use strict";

const menu = document.getElementById("setting-menu");
const settings = document.getElementById("settings");

function handleClickMenu() {
  settings.classList.remove("hidden");
}

function handleClickSettingBackground(e) {
  if (e.target !== e.currentTarget) {
    return;
  }

  settings.classList.add("hidden");
}

menu.addEventListener("click", handleClickMenu);
settings.addEventListener("click", handleClickSettingBackground);
