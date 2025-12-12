
    <?php
    function renderSearchBar()
    {
        return <<<HTML
    <form class="header__search-bar" onsubmit="return false;">
        <label>
            <i class="fa-solid fa-magnifying-glass"></i>
            <input 
                type="text"
                placeholder="Buscar músicas, álbuns ou artistas..."
                oninput="search(this.value)"
            >
        </label>
    </form>
    HTML;
    }
