<body>
    <header>
        <nav>
            <div>
                <a href="index.php">
                    <img id="icon" src="images/logo.png" alt="Home logo" />
                </a>
                <select onchange="handleSelection(this.value)" id="navbox" name="option">
                    <option disabled selected>Select an Option...</option>
                    <option value="index.php">Home</option>
                    <option value="pets.php">Pets</option>
                    <option value="add.php">Add more</option>
                    <option value="gallery.php">Gallery</option>
                </select>
            </div>

            <div>
                <input type="text" id="searchbox" placeholder="Search" />
                <div id="searching">
                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">
                        <img id="searching" src="images/searchingtool.png" alt="Searching sign" />
                    </a>
                </div>
            </div>
        </nav>
    </header>