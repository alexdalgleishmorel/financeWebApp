<?php

function calculateNetworth ($accounts, $assets) {

    if(!session_id()) session_start();

    $totalBookValue = 0;
    $totalNetWorth = 0;

    if ($accounts != 'empty') {
        foreach ($accounts as $account) {
            // Convert to CAD currency from the current supported currencies
            $currency = $account['currency'];
            $cadValue = NULL;
    
            switch ($currency) {
                case 'USD':
                    $_SESSION['ticker'] = 'CADUSD=X';
                    include('getMarketPrice.php');
                    $conversionRatio = 1/$_SESSION['marketPrice'];
                    $cadValue = $account['value']*$conversionRatio;
                    break;
                case 'EUR':
                    $_SESSION['ticker'] = 'CADEUR=X';
                    include('getMarketPrice.php');
                    $conversionRatio = 1/$_SESSION['marketPrice'];
                    $cadValue = $account['value']*$conversionRatio;
                    break;
                case 'GBP':
                    $_SESSION['ticker'] = 'CADGBP=X';
                    include('getMarketPrice.php');
                    $conversionRatio = 1/$_SESSION['marketPrice'];
                    $cadValue = $account['value']*$conversionRatio;
                    break;
                case 'JPY':
                    $_SESSION['ticker'] = 'CADJPY=X';
                    include('getMarketPrice.php');
                    $conversionRatio = 1/$_SESSION['marketPrice'];
                    $cadValue = $account['value']*$conversionRatio;
                    break;
                default:
                    $cadValue = $account['value'];
                    break;
            }
    
            $totalBookValue += $cadValue;
            $totalNetWorth += $cadValue;
        }
    }

    if ($assets != 'empty') {
        foreach ($assets as $asset) {
            // Convert to CAD currency from the current supported currencies
            $currency = $asset->currency;
            $cadBookValue = NULL;
            $cadMarketValue = NULL;
    
            switch ($currency) {
                case 'USD':
                    $_SESSION['ticker'] = 'CADUSD=X';
                    include('getMarketPrice.php');
                    $conversionRatio = 1/$_SESSION['marketPrice'];
                    $cadBookValue = $asset->bookValue*$conversionRatio;
                    $cadMarketValue = $asset->marketValue*$conversionRatio;
                    break;
                case 'EUR':
                    $_SESSION['ticker'] = 'CADEUR=X';
                    include('getMarketPrice.php');
                    $conversionRatio = 1/$_SESSION['marketPrice'];
                    $cadBookValue = $asset->bookValue*$conversionRatio;
                    $cadMarketValue = $asset->marketValue*$conversionRatio;
                    break;
                case 'GBP':
                    $_SESSION['ticker'] = 'CADGBP=X';
                    include('getMarketPrice.php');
                    $conversionRatio = 1/$_SESSION['marketPrice'];
                    $cadBookValue = $asset->bookValue*$conversionRatio;
                    $cadMarketValue = $asset->marketValue*$conversionRatio;
                    break;
                case 'JPY':
                    $_SESSION['ticker'] = 'CADJPY=X';
                    include('getMarketPrice.php');
                    $conversionRatio = 1/$_SESSION['marketPrice'];
                    $cadBookValue = $asset->bookValue*$conversionRatio;
                    $cadMarketValue = $asset->marketValue*$conversionRatio;
                    break;
                default:
                    $cadBookValue = $asset->bookValue;
                    $cadMarketValue = $asset->marketValue;
                    break;
            }
    
            $totalBookValue += $cadBookValue;
            $totalNetWorth += $cadMarketValue;
        }
    }

    if ($totalBookValue == 0 && $totalNetWorth == 0) {
        return array(0,0,0,0);
    }

    $gainLossD = $totalNetWorth-$totalBookValue;
    $gainLossP = ($gainLossD/$totalBookValue)*100;

    return array($totalBookValue, $totalNetWorth, $gainLossD, $gainLossP);
}

?>