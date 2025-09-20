import { toggler } from "./navigation.js";

const icon = document.querySelector("#toggler");
if (icon) {
  icon.addEventListener("click", toggler);
}
