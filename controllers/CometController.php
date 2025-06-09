<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../models/CometModel.php';
require_once '../entities/Comet.php';

$cometModel = new CometModel();

$action = $_GET['action'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'add':
            handleAddComet($cometModel);
            break;
        case 'update':
            handleUpdateComet($cometModel);
            break;
        default:
            header('Location: ../views/LoginPage.php');
            exit;
    }
} else {
    switch ($action) {
        case 'delete':
            handleDeleteComet($cometModel);
            break;
        default:
            header('Location: ../views/LoginPage.php');
            exit;
    }
}

function handleUpdateComet(CometModel $cometModel)
{
    $cometId = $_POST['id'] ?? null;

    if ($cometId) {
        $name = trim($_POST['name'] ?? '');
        $features = trim($_POST['features'] ?? '');
        $lastObserved = trim($_POST['last_observed'] ?? '');
        $orbitalPeriod = isset($_POST['orbital_period_years']) ? floatval($_POST['orbital_period_years']) : null;
        $description = trim($_POST['description'] ?? '');
        $categoryId = isset($_POST['category_id']) ? intval($_POST['category_id']) : null;
        $imageFilename = trim($_POST['image'] ?? '');

        $imagePath = null;
        if (!empty($imageFilename)) {
            $imagePath = '../assets/images/comets/' . $imageFilename;
        }

        if (empty($name)) {
            header("Location: ../admin/AdminComet.php?error=empty-comet-name");
            exit;
        }

        $updatedComet = new Comet(
            (int)$cometId,
            $name,
            $features,
            $lastObserved,
            $orbitalPeriod,
            $description,
            $imagePath,
            $categoryId
        );

        $success = $cometModel->updateComet($updatedComet);
        if ($success) {
            header("Location: ../admin/AdminComet.php?success=comet-updated");
            exit;
        } else {
            header("Location: ../admin/AdminComet.php?error=update-failed");
            exit;
        }
    } else {
        header('Location: ../admin/AdminComet.php?error=invalid_comet_id');
        exit;
    }
}

function handleAddComet(CometModel $cometModel)
{
    $name = trim($_POST['name'] ?? '');
    $features = trim($_POST['features'] ?? '');
    $lastObserved = trim($_POST['last_observed'] ?? '');
    $orbitalPeriod = isset($_POST['orbital_period_years']) ? floatval($_POST['orbital_period_years']) : null;
    $description = trim($_POST['description'] ?? '');
    $categoryId = isset($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $imageFilename = trim($_POST['image'] ?? '');

    $imagePath = null;
    if (!empty($imageFilename)) {
        $imagePath = '../assets/images/comets/' . $imageFilename;
    }

    if (empty($name)) {
        header("Location: ../admin/AdminComet.php?error=empty-comet-name");
        exit;
    }

    $newComet = new Comet(
        null,
        $name,
        $features,
        $lastObserved,
        $orbitalPeriod,
        $description,
        $imagePath,
        $categoryId
    );

    $success = $cometModel->createComet($newComet);

    if ($success) {
        header("Location: ../admin/AdminComet.php?success=comet-added");
        exit;
    } else {
        header("Location: ../admin/AdminComet.php?error=create-failed");
        exit;
    }
}

function handleDeleteComet(CometModel $cometModel)
{
    $userId = $_GET['id'] ?? $_POST['id'] ?? null;

    if ($userId) {
        $success = $cometModel->deleteComet($userId);

        if ($success) {
            header('Location: ../admin/AdminComet.php?success=comet-deleted');
            exit;
        } else {
            header('Location: ../admin/AdminComet.php?error=comet-not-deleted');
            exit;
        }
    } else {
        header('Location: ../admin/AdminComet.php?error=invalid_comet_id');
        exit;
    }
}
