export function cloneTemplate(id) {
  const tpl = document.getElementById(id);
  return tpl.content.firstElementChild.cloneNode(true);
}

export function renderMessage(message, container, type = "info", clear = true) {
  if (clear) container.innerHTML = "";
  const msgEl = cloneTemplate("message-template");
  msgEl.textContent = message;
  msgEl.classList.add(type);
  container.appendChild(msgEl);
}
