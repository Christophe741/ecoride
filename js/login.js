import { domReady } from "./domReady.js";

domReady(() => {
  const form = document.getElementById("login-form");
  const error = document.getElementById("login-error");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const payload = {
      email: form.email.value,
      password: form.password.value,
    };

    try {
      const res = await fetch("api/login.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(payload),
      });

      const data = await res.json();
      if (data.success) {
        if (data.role === "admin") {
          window.location.href = "admin/index.php";
        } else {
          window.location.href = "index.php";
        }
      } else {
        error.textContent = "Email ou mot de passe incorrect.";
      }
    } catch (err) {
      error.textContent = "Erreur de connexion.";
    }
  });
});
