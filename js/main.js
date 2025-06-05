import { domReady } from "./domReady.js";
import { fixFouc } from "./fouc-fix.js";
import { toggler } from "./toggler.js";

domReady(() => {
  fixFouc();
  const icon = document.querySelector("#toggler");
  if (icon) {
    icon.addEventListener("click", toggler);
  }
});
