export function toggler() {
  const icon = document.querySelector("#toggler");
  const menu = document.querySelector(".header__menu");
  const body = document.body;

  if (icon.innerHTML == "menu") {
    icon.innerHTML = "close";
    menu.style.display = "flex";
    body.style.overflow = "hidden";
  } else {
    icon.innerHTML = "menu";
    menu.style.display = "none";
    body.style.overflow = "";
  }
}
