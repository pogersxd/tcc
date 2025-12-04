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
      else {
        container.innerHTML = html;
      }
      if (componentName === "register") confirmarSenha();
    })
    .catch((error) => {
      console.error("Erro ao carregar componente:", error);
    });
}

function reloadLeftBar() {
  const leftbar = document.getElementById("left-bar");

  fetch("./components/leftBar.php")
    .then(response => response.text())
    .then(data => {
      leftbar.outerHTML = data;
    })
    .catch(err => { console.error(err) });
}

function reloadHeader() {
  const header = document.getElementById("header");

  fetch("./components/header.php")
    .then(response => response.text())
    .then(data => {
      header.outerHTML = data;
    })
    .catch(err => { console.error(err) });
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

      if (form.id === "add-music-form" && data.status === "success") {
        fetch("./components/addMusicForm.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "id_album=" + encodeURIComponent(data.id)
        }).then(response => response.text())
          .then(data => {
            const container = document.getElementById('main-menu');
            container.innerHTML = data;
            reloadLeftBar();
          })
          .catch(err => console.error(err));
      }
      else loadComponent(data.nextComponent);

      if (form.id === "loginForm" && data.status === "success") {
        window.location.reload();
      }
    });
});

document.addEventListener("click", function (event) {
  const btnDeleteAlbum = event.target.closest(".deleteAlbumBtn");
  const manageSongs = event.target.closest(".manageSongs");
  const btnDeleteSong = event.target.closest(".deleteSongBtn");

  if (btnDeleteAlbum) {
    event.preventDefault();

    const id = btnDeleteAlbum.dataset.id;
    fetch("./deleteAlbum.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: "id_album=" + encodeURIComponent(id)
    }).then(response => response.json())
      .then(data => {
        loadComponent(data.nextComponent)
        window.alert(data.message)
        reloadLeftBar();
      })
      .catch(err => console.error(err));
  }

  if (manageSongs) {
    event.preventDefault();

    const container = document.getElementById('main-menu');

    const id = manageSongs.dataset.id;

    fetch("./components/\addMusicForm.php", {
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

  if (btnDeleteSong) {
    event.preventDefault();

    const id_musica = btnDeleteSong.dataset.song;
    const id_album = btnDeleteSong.dataset.album;

    fetch("./deleteSong.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: "id_musica=" + encodeURIComponent(id_musica) +
        "&id_album=" + encodeURIComponent(id_album)
    }).then(response => response.json())
      .then(data => {
        window.alert(data.message);
        fetch(`./components/${data.nextComponent}.php`, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "id_album=" + encodeURIComponent(data.id)
        }).then(response => response.text())
          .then(data => {
            const container = document.getElementById('main-menu');
            container.innerHTML = data;
            if (data.status === "success") reloadLeftBar();
          })
          .catch(err => {
            console.error(err);
          })
      }).catch(err => {
        console.error(err);
      })
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
      return;
    } else {
      mensagem.innerHTML = "";
      botao.disabled = false;
    }
  }
  senha.addEventListener("input", verificarSenhas);
  confirmarSenha.addEventListener("input", verificarSenhas);
}