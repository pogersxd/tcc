
    <?php
    function renderSearchBar()
    {
        return <<<HTML
    <form class="header__search-bar" onsubmit="return false;">
        <label style="
        display: flex;
        gap: 10px;
        flex-direction: row;
        ">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input 
                type="text"
                placeholder="Buscar..."
                oninput="search(this.value)"
            >
        </label>
    </form>
    HTML;
    }
