import { domReady } from "./domReady.js";
import { fixFouc } from "./fouc-fix.js";

domReady(() => {
  fixFouc();
});
