<?php

if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
    redirect('login');
}
