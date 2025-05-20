function loadComponent(componentName) {
  const container = document.getElementById("main-menu");

  if (!container) {
    console.error("Container 'main-menu' não encontrado.");
    return;
  }

  // Faz a requisição para o componente (PHP)
  fetch(`./components/${componentName}.php`)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erro ao carregar componente.");
      }
      return response.text(); // HTML como texto
    })
    .then((html) => {
      container.innerHTML = html;

      // Carrega scripts adicionais se necessário
      // if (componentName === "player") {
      //   const script = document.createElement("script");
      //   script.src = "js/playerScript.js";
      //   document.body.appendChild(script);
      // }
    })
    .catch((error) => {
      console.error("Erro ao carregar componente:", error);
    });
}
