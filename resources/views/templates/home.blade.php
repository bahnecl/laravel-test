@extends('layouts.default')

@section('content')
    
    @if (count($invoices) > 0)
        <section class="wrap clearfix">
            <h1 class="title">Deine Superkräfte</h1>
            @foreach($invoices as $invoice)
                @foreach($invoice->products as $activeProduct)
                    <article class="col-md-4 col-sm-6 col-xm-12">
                        <div class="product-item">
                            <img class="center-image" width="150" src="public/{{$activeProduct->image}}" alt="product-item-img">
                            <h4>{{$activeProduct->title}}</h4>
                        </div>
                    </article>
                @endforeach
            @endforeach
        </section>
    @endif

    <section class="wrap clearfix">
        <h1 class="title">Keine Kraft mehr? Lade deine Superkräfte auf:</h1>
        @foreach($products as $product)
            <article class="col-md-4 col-sm-6 col-xm-12">
                <div class="product-item">
                    <img class="center-image" width="150" src="public/{{$product->image}}" alt="product-item-img">
                    <h4>{{$product->title}}</h4>
                    <a href="{{route('create.invoice', $product->id)}}" class="btn btn-primary btn-lg">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        Aufladen <span class="price">({{$product->price}} €)</span>
                    </a>
                </div>
            </article>
        @endforeach
    </section>

    @if (count($invoices) > 0)
        <section class="wrap clearfix">
            <h1 class="title">Deine Rechnungen</h1>
            <ul class="list-group">
                @foreach($invoices as $indexKey => $invoice)
                   <li class="list-group-item">
                        <span class="list-spacing invoice-key">{{$indexKey+1}}</span>
                        <span class="list-spacing invoice-price">{{$invoice->price}} €</span>
                        <span class="list-spacing invoice-date">{{$invoice->date->format('d.m.Y')}}</span>
                        <span class="list-spacing invoice-product">{{$invoice->products->first()->title}}</span>
                        <span class="list-spacing invoice-payment-type">Wurde per {{$invoice->payment_type}} gekauft</span>
                   </li>
                @endforeach
            </ul>
        </section>
    @endif

@endsection


