<?php
unset($_SESSION['SessionBookCategories']);
unset($_SESSION['SessionBookSubCategories']);
unset($_SESSION['SessionStationaryCategories']);
unset($_SESSION['SessionStationarySubCategories']);
$_SESSION['SessionBookCategories'] = $vQuery->getExistingCategories($conn, 1, 1);
$_SESSION['SessionBookSubCategories'] = $vQuery->getExistingSubCategories($conn, 1, 1);
$_SESSION['SessionStationaryCategories'] = $vQuery->getExistingCategories($conn, 1, 3);
$_SESSION['SessionStationarySubCategories'] = $vQuery->getExistingSubCategories($conn, 1, 3);
