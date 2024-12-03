<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halloween Costume Contest</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Creepster&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: url('https://img.freepik.com/premium-photo/scary-halloween-charm-horror-white-ghost-with-fangs-carrying-cobwebwrapped-spooky-pumpkin_981289-353.jpg?w=740') no-repeat center center fixed;
        background-size: cover;
        color: #f5f5f5;
        font-family: 'Arial', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .form-container {
        background-color: rgba(0, 0, 0, 0.8); /* Transparent dark background */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        margin-top: 50px;
        z-index: 1;
        position: relative;
    }

    .btn-custom {
        background-color: #e74c3c;
        color: white;
        border: none;
    }

    .btn-custom:hover {
        background-color: #c0392b;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-family: 'Creepster', cursive;
        color: #e74c3c;
    }

    label {
        font-weight: 400;
        font-family: 'Creepster', cursive;
    }

    canvas {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
    }

    .lightning {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        opacity: 0;
        pointer-events: none;
        z-index: 10;
        animation: flash 0.2s ease-in-out infinite;
    }

    @keyframes flash {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }
</style>

</head>

<body>
    <canvas id="halloweenCanvas"></canvas>
<audio id="horrorMusic" autoplay loop>
    <source src="https://www.soundjay.com/horror/horror-sound-01.mp3" type="audio/mpeg">
 </audio>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="halloween">Halloween Costume Contest</h2>
                    <form action="index_process.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="fullname" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" placeholder="Enter your age" required>
                        </div>
                        <div class="mb-3">
                            <label for="costume" class="form-label">Costume Title</label>
                            <select class="form-select" id="costume" name="costume" required>
                                <option selected disabled>Select your costume</option>
                                <option value="Vampire">Vampire</option>
                                <option value="Witch">Witch</option>
                                <option value="Zombie">Zombie</option>
                                <option value="Ghost">Ghost</option>
                                <option value="Skeleton">Skeleton</option>
                                <option value="Superhero">Superhero</option>
                                <option value="Pirate">Pirate</option>
                                <option value="Werewolf">Werewolf</option>
                                <option value="Clown">Clown</option>
                                <option value="Mummy">Mummy</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category" required>
                                <option selected disabled>Select a category</option>
                                <option value="1">Scariest Costume</option>
                                <option value="2">Funniest Costume</option>
                                <option value="3">Most Creative Costume</option>
                                <option value="4">Best Group Costume</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-custom w-100" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for Background Animation -->
    <script>
    const canvas = document.getElementById('halloweenCanvas');
    const ctx = canvas.getContext('2d');

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const spookyIcons = [];
    const iconImages = [
        { src: "https://img.icons8.com/ios/452/ghost.png", type: "ghost" },
        { src: "https://img.icons8.com/ios/452/bat.png", type: "bat" },
        { src: "https://img.icons8.com/ios/452/spider.png", type: "spider" },
     
    ];

    class SpookyIcon {  
        constructor(imageSrc, type) {
            this.x = Math.random() * canvas.width;
            this.y = type === "bat" ? canvas.height + 50 : -50; // Bats start at the bottom
            this.size = 30 + Math.random() * 50;
            this.speed = 1 + Math.random() * 2;
            this.image = new Image();
            this.image.src = imageSrc;
            this.type = type;
        }

        draw() {
            ctx.drawImage(this.image, this.x, this.y, this.size, this.size);
        }

        update() {
            if (this.type === "bat") {
                this.y -= this.speed; // Move bats upward
                if (this.y < -50) { // Reset bats when they move off the top
                    this.y = canvas.height + 50;
                    this.x = Math.random() * canvas.width;
                }
            } else {
                this.y += this.speed; // Move other icons downward
                if (this.y > canvas.height) { // Reset other icons when they move off the bottom
                    this.y = -50;
                    this.x = Math.random() * canvas.width;
                }
            }
        }
    }

    function createSpookyIcons() {
        for (let i = 0; i < 15; i++) {
            const randomImage = iconImages[Math.floor(Math.random() * iconImages.length)];
            spookyIcons.push(new SpookyIcon(randomImage.src, randomImage.type));
        }
    }

    function animateIcons() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        spookyIcons.forEach(icon => {
            icon.update();
            icon.draw();
        });
        requestAnimationFrame(animateIcons);
    }

    window.onload = () => {
        createSpookyIcons();
        animateIcons();
    };
</script>

</body>

</html>
