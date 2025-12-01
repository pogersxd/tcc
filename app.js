function loadComponent(componentName) {
  const container = document.getElementById("main-menu");

  if (!container) {
    console.error("Container 'main-menu' não encontrado.");
    return;
  }

  fetch(`./components/${componentName}.php`)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erro ao carregar componente.");
      }
      return response.text();
    })
    .then((html) => {
      if (componentName === "mainMenu") container.outerHTML = html;
      else container.innerHTML = html;
      if (componentName === "register") confirmarSenha();
    })
    .catch((error) => {
      console.error("Erro ao carregar componente:", error);
    });
}

document.addEventListener("submit", function (event) {
  const form = event.target;
  let arquivo;
  switch (form.id) {
    case "add-album-form":
      arquivo = "./addAlbum.php";
      break;
    case "registerForm":
      arquivo = "./createAccount.php";
      break;
    case "loginForm":
      arquivo = "./verifyLogin.php";
      break;
    case "add-music-form":
      arquivo = "./addMusica.php";
      break;
  }

  event.preventDefault();
  const formData = new FormData(form);

  fetch(arquivo, {
    method: "POST",
    body: formData,
  })
    .then(response => response.json())
    .then(data => {
      window.alert(data.message);
      if (form.id === "loginForm" && data.status === "success") window.location.reload();
      else loadComponent(data.nextComponent);
    })
    .catch(err => console.error(err));
}
);

document.addEventListener("click", function (event) {
  const btnDeleteAlbum = event.target.closest(".deleteAlbumBtn");
  const manageSongs = event.target.closest(".manageSongs");
  let usado;
  let caminho;
  if (btnDeleteAlbum) {
    usado = btnDeleteAlbum;
    caminho = "deleteAlbum.php";
    event.preventDefault();

    const id = usado.dataset.id;
    fetch(caminho, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: "id_album=" + encodeURIComponent(id)
    }).then(response => response.json())
      .then(data => {
        loadComponent(data.nextComponent)
        window.alert(data.message)
      })
      .catch(err => console.error(err));
  }

  if (manageSongs) {
    usado = manageSongs
    caminho = "components/\addMusicForm.php";
    event.preventDefault();
    const container = document.getElementById('main-menu');
    const id = usado.dataset.id;
    fetch(caminho, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: "id_album=" + encodeURIComponent(id)
    }).then(response => response.text())
      .then(data => {
        container.innerHTML = data;
      })
      .catch(err => console.error(err));
  }
});


// Register
function confirmarSenha() {
  const senha = document.getElementById("senha");
  const confirmarSenha = document.getElementById("confirmar");
  const botao = document.getElementById("botao");
  const mensagem = document.getElementById("mensagem");

  function verificarSenhas() {
    if (senha.value === "" || confirmarSenha.value === "") {
      mensagem.innerHTML = "";
      botao.disabled = true;
      return;
    }
    if (senha.value != confirmarSenha.value) {
      mensagem.innerHTML = "As senhas não coincidem";
      botao.disabled = true;
    } else {
      mensagem.innerHTML = "";
      botao.disabled = false;
    }
  }
  senha.addEventListener("input", verificarSenhas);
  confirmarSenha.addEventListener("input", verificarSenhas);
}