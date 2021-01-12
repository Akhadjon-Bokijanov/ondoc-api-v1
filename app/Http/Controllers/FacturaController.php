<?php

namespace App\Http\Controllers;

use App\Models\Factura;
//use Barryvdh\DomPDF\PDF;
use App\Models\FacturaProduct;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$facturas = auth()->user()->facturas;
        $facturas = Factura::all();
        return $facturas;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create factura
        return Factura::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $factura = Factura::find($id);
        $factura->facturaProducts->orderBy(["ordNo"=>"desc"]);
        return $factura;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factura $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $factura)
    {
        //delete factura and factura products
        FacturaProduct::destroy(['facturaProductId'=>$factura->facturaProductid]);
        return $factura->delete();
    }


    //Generating Factura PDF file
    public function generatePdf($id){

        $data = Factura::find($id);
        $data->productFacturas;
        //return view('pdf.factura_template', ['data'=>$data]);

        $pdf = PDF::loadView('pdf.factura_template', ["data"=>$data])
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isPhpEnabled'=>true,
                "isHtml5ParserEnabled"=>true,
                "isRemoteEnabled"=>true
                ]);

        $pdf->setOptions(['isPhpEnabled'=>true]);

        return $pdf->stream('factura-'.$data->facturaId.'.pdf');
    }

}
