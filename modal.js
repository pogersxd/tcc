function openDeleteModal(type, id) {
    const modal = document.getElementById("confirmModal" + id);
    const modalTitle = document.getElementById("modalTitle" + id);
    const modalMessage = document.getElementById("modalMessage" + id);
    const cancelBtn = modal.querySelector(".cancelBtn");
    let dado;

    modal.style.display = "flex";
    if (type == "music") {
        dado = "id_musica";
        modalTitle.innerHTML = "<h2>Excluir música</h2>";
    } else {
        dado = "id_album";
        modalTitle.innerHTML = "<h2>Excluir álbum</h2>";
    }

    fetch("getAlbumMusicModal.php?" + dado + "=" + id)
        .then(res => res.text()
            .then(data => {
                if (type == "music") modalMessage.innerHTML = "<p>Deseja excluir a seguinte música? <br><b>" + data + " ?</b></p>";
                else modalMessage.innerHTML = "<p>Ao excluir este álbum, excluirá também as seguintes músicas, tem certeza?<br> <b>" + data + "</b></p>";
            }))

    cancelBtn.addEventListener("click", function (event) {
        event.preventDefault();
        modal.style.display = "none";
    })
}