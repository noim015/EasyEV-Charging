<?php include '../includes/header.php'; ?>

<div class="container" style="padding:2% 0;">
    <h2 style="text-align: center;">Contact Us</h2>

    <form method="POST" action="contact.php" style="margin-top: 30px;">
        <label for="name">Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="message">Message:</label><br>
        <textarea name="message" rows="5" required style="width: 100%; padding: 10px;"></textarea><br><br>

        <button type="submit">Send Message</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize input
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        // For now, just display the message (simulate sending)
        echo "<p style='color: green; margin-top: 20px;'>Thank you, $name! Your message has been received.</p>";
    }
    ?>
</div>

<?php include '../includes/footer.php'; ?>
