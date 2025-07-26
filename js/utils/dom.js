export function cloneTemplate(id) {
  const tpl = document.getElementById(id);
  return tpl?.content.firstElementChild.cloneNode(true);
}

export function renderError(message, container) {
  const errorEl = cloneTemplate("error-template");
  errorEl.textContent = message;
  container.appendChild(errorEl);
}
