<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Masters\StandardPackingList;
use App\Models\Configurations\Cargo;
use App\Models\Configurations\Courier;

/**
 * Description of EstimateCalculationController
 *
 * @author Archisys
 */
class EstimateCalculationController extends APIController {
    
    function estimate(Request $request){
        $totalQty = $request->get('qty');
        $totalQtyTemp = $request->get('qty');
        $fgcode = $request->get('fgcode');
        $transactionMod = $request->get('transactionMode');
        //var_dump($transactionMod);exit;
        $count = 0;
        $qtyArray = array();
        $volumeArray = array();
        $totalQtyArray = array();

        if($transactionMod == 'Cargo'){
            $cargo = Cargo::first();    
        }

        if($transactionMod == 'Courier'){
            $courier = Courier::first();
        }
        
        //var_dump($courier);exit;       
        $standardPackingList = StandardPackingList::where(['fgcode' => $fgcode])->first();
        $sizeArray = array(
            (int)$standardPackingList['20x20x28'],
            (int)$standardPackingList['30x28x25'],
            (int)$standardPackingList['41x33x34'],
            (int)$standardPackingList['61x41x47']
            );
        rsort($sizeArray);
//        for ($count = 0; $count < count($sizeArray); $count ++) {
            $qty = 0;
            $qty1 = 0;
            $qty2 = 0;
            $qty3 = 0;
            if ($totalQty > 0) {
                $qty = ceil($totalQty / $sizeArray[0]);
                if($transactionMod == 'Cargo'){
                    $volume = ceil($qty*$cargo->cargo_box_weight_61x41x47);
                }
                if($transactionMod == 'Courier'){
                    $volume = ceil($qty*$courier->courier_box_weight_61x41x47);   
                }
                $totalQty -= $sizeArray[0] * $qty;
                $qtyArray1 = array($sizeArray[0],$qty);
                array_push($qtyArray, $qtyArray1);
                array_push($volumeArray, $volume);
                array_push($totalQtyArray, $totalQty);
            }
            $totalQty = $totalQtyTemp;
            if ($totalQty > 0) {
                $qty = floor($totalQty / $sizeArray[0]);
                $totalQty -= $sizeArray[0] * $qty;
                
                if ($totalQty > 0) {
                    $qty1 = ceil($totalQty / $sizeArray[1]);
                    $totalQty -= $sizeArray[1] * $qty1;
                }
                $qtyArray1 = array($sizeArray[0], $qty, $sizeArray[1], $qty1);
                array_push($qtyArray, $qtyArray1);

                if($transactionMod == 'Cargo'){
                    $volume = ceil(($qty1*$cargo->cargo_box_weight_41x33x34)+($qty*$cargo->cargo_box_weight_61x41x47));
                }

                if($transactionMod == 'Courier'){
                    $volume = ceil(($qty1*$courier->courier_box_weight_41x33x34)+($qty*$courier->courier_box_weight_61x41x47));
                }

                array_push($volumeArray, $volume);
                array_push($totalQtyArray, $totalQty);
            }
            $totalQty = $totalQtyTemp;
            if ($totalQty > 0) {
                $qty = floor($totalQty / $sizeArray[0]);
                $totalQty -= $sizeArray[0] * $qty;
                
                if ($totalQty > 0) {
                    $qty1 = floor($totalQty / $sizeArray[1]);
                    $totalQty -= $sizeArray[1] * $qty1;
                }
                if ($totalQty > 0) {
                    $qty2 = ceil($totalQty / $sizeArray[2]);
                    $totalQty -= $sizeArray[2] * $qty2;
                }
                while ($totalQty > 0 && $totalQty > $sizeArray[3]) {
                    $tempQty = ceil($totalQty / $sizeArray[2]);
                    $totalQty -= $sizeArray[2] * $tempQty;
                    $qty2 += $tempQty;
                    break;
                }
                while ($totalQty > 0) {
                    $tempQty = ceil($totalQty / $sizeArray[3]);
                    $totalQty -= $sizeArray[3] * $tempQty;
                    $qty3 += $tempQty;
                    break;
                }

                if($transactionMod == 'Cargo'){
                    $volume = ceil(($qty3*$cargo->cargo_box_weight_20x20x28)+($qty2*$cargo->cargo_box_weight_30x28x25)+($qty1*$cargo->cargo_box_weight_41x33x34)+($qty*$cargo->cargo_box_weight_61x41x47));
                }

                if($transactionMod == 'Courier'){
                    $volume = ceil(($qty3*$courier->courier_box_weight_20x20x28)+($qty2*$courier->courier_box_weight_30x28x25)+($qty1*$courier->courier_box_weight_41x33x34)+($qty*$courier->courier_box_weight_61x41x47));
                }

                $qtyArray1 = array($sizeArray[0], $qty, $sizeArray[1], $qty1, $sizeArray[2], $qty2, $sizeArray[3], $qty3);
                array_push($qtyArray, $qtyArray1);
                array_push($volumeArray, $volume);
                array_push($totalQtyArray, $totalQty);
            }
            $totalQty = $totalQtyTemp;
            if ($totalQty > 0) {
                $qty = floor($totalQty / $sizeArray[0]);
                $totalQty -= $sizeArray[0] * $qty;
                
                if ($totalQty > 0) {
                    $qty1 = floor($totalQty / $sizeArray[1]);
                    $totalQty -= $sizeArray[1] * $qty1;
                }
                
                if ($totalQty > 0) {
                    $qty2 = floor($totalQty / $sizeArray[2]);
                    $totalQty -= $sizeArray[2] * $qty2;
                }
                
                if ($totalQty > 0) {
                    $qty3 = ceil($totalQty / $sizeArray[3]);
                    $totalQty -= $sizeArray[3] * $qty3;
                }
                while ($totalQty > 0) {
                    $tempQty = floor($totalQty / $sizeArray[3]);
                    $totalQty -= $sizeArray[3] * $tempQty;
                    $qty3 += $tempQty;
                    break;
                }
                if($transactionMod == 'Cargo'){
                    $volume = ceil(($qty3*$cargo->cargo_box_weight_20x20x28)+($qty2*$cargo->cargo_box_weight_30x28x25)+($qty1*$cargo->cargo_box_weight_41x33x34)+($qty*$cargo->cargo_box_weight_61x41x47));
                }

                if($transactionMod == 'Courier'){
                    $volume = ceil(($qty3*$courier->courier_box_weight_20x20x28)+($qty2*$courier->courier_box_weight_30x28x25)+($qty1*$courier->courier_box_weight_41x33x34)+($qty*$courier->courier_box_weight_61x41x47));
                }
                $qtyArray1 = array($sizeArray[0], $qty, $sizeArray[1], $qty1, $sizeArray[2], $qty2, $sizeArray[3], $qty3);
                array_push($qtyArray, $qtyArray1);
                array_push($volumeArray, $volume);
                array_push($totalQtyArray, $totalQty);
            }
            $totalQty = $totalQtyTemp;
            if ($totalQty > 0) {
                $qty = floor($totalQty / $sizeArray[0]);
                $totalQty -= $sizeArray[0] * $qty;
                
                if ($totalQty > 0) {
                    $qty1 = floor($totalQty / $sizeArray[1]);
                    $totalQty -= $sizeArray[1] * $qty1;
                }
                if ($totalQty > 0) {
                    $qty2 = floor($totalQty / $sizeArray[2]);
                    $totalQty -= $sizeArray[2] * $qty2;
                }
                while ($totalQty > 0) {
                    $tempQty = floor($totalQty / $sizeArray[3]);
                    $totalQty -= $sizeArray[3] * $tempQty;
                    $qty3 += $tempQty;
                    break;
                }

                if($transactionMod == 'Cargo'){
                    $volume = ceil(($qty3*$cargo->cargo_box_weight_20x20x28)+($qty2*$cargo->cargo_box_weight_30x28x25)+($qty1*$cargo->cargo_box_weight_41x33x34)+($qty*$cargo->cargo_box_weight_61x41x47));
                }

                if($transactionMod == 'Courier'){
                    $volume = ceil(($qty3*$courier->courier_box_weight_20x20x28)+($qty2*$courier->courier_box_weight_30x28x25)+($qty1*$courier->courier_box_weight_41x33x34)+($qty*$courier->courier_box_weight_61x41x47));
                }
                
                
                $qtyArray1 = array($sizeArray[0], $qty, $sizeArray[1], $qty1, $sizeArray[2], $qty2, $sizeArray[3], $qty3);
                array_push($qtyArray, $qtyArray1);
                array_push($volumeArray, $volume);
                array_push($totalQtyArray, $totalQty);
            }
//        }
        // var_dump($volumeArray);
        // var_dump("QTY: ",$qtyArray);
        // var_dump("QTY: ",$totalQtyArray);
        // exit;
        return response()->json(["code" => 200, "message" => 'success', "volumeArry" => $volumeArray, "totalQtyArray" => $totalQtyArray, "qtyArray" => $qtyArray], 200);
/*
        while($totalQty >= min($sizeArray))
        {
            if ($count >= count($sizeArray)) { 
                if ($totalQty <= min($sizeArray))
                    $totalQty = 0;
                break;
            }
            $qty = $totalQty / $sizeArray[$count];
            if (floor($qty) > 0)
                $totalQty -= $sizeArray[$count];
            var_dump("Calculation :".$sizeArray[$count], floor($qty));
            $count++;
            if ($count == 10)
                 break;
        }
        while ($totalQty > 0) {
            $totalQty -= min($sizeArray);
            var_dump("Calculation: ".min($sizeArray), 1);
        }
         var_dump("Total Qty :".$totalQty);
        exit;
        */
    }
    
}
