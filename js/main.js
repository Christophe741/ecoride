import { domReady } from "./domReady.js";
import { toggler } from "./navigation.js";

domReady(() => {
  const icon = document.querySelector("#toggler");
  if (icon) {
    icon.addEventListener("click", toggler);
  }
});
