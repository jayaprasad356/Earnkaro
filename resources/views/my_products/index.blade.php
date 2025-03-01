@extends('layouts.admin')

@section('title', 'Products Management')
@section('content-header', 'Products Management')
@section('content-actions')
@endsection
@section('content')
<style>
    .card-img-top {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .stars {
        color:#6fd943;
        font-size: 25px;
    }
    .discount {
        color: #6fd943;
        font-weight: bold;
    }
    .original-price {
        text-decoration: line-through;
        color: grey;
    }
    .final-price {
        font-weight: bold;
        font-size: 18px;
     
    }
    .free-delivery {
        color: blue;
        font-weight: bold;
    }
    .price-container {
        display: flex;
        gap: 10px;
        align-items: center;
    }
</style>

<h3>My Products</h3>
<div class="row">
    @php
        $products = [
            [
                'name' => 'Organic Turmeric Powder',
                'description' => 'Pure and natural turmeric powder',
                'original_price' => 299,
                'discounted_price' => 168,
                'image_url' => 'https://t4.ftcdn.net/jpg/04/72/24/73/360_F_472247342_JK2YdMdXnW4be8n0iAbxcqnc3X85EXKb.jpg'
            ],
            [
                'name' => 'Organic Honey',
                'description' => 'Raw and unfiltered honey',
                'original_price' => 350,
                'discounted_price' => 250,
                'image_url' => 'https://i.etsystatic.com/23784133/r/il/c08811/3273966018/il_fullxfull.3273966018_mo0s.jpg'
            ],
            [
                'name' => 'Organic Almonds',
                'description' => 'Natural and healthy almonds',
                'original_price' => 450,
                'discounted_price' => 350,
                'image_url' => 'https://www.greendna.in/cdn/shop/products/almond2_1200x1200.jpeg?v=1564303633'
            ],
            [
                'name' => 'Organic Green Tea',
                'description' => 'Refreshing and healthy green tea',
                'original_price' => 250,
                'discounted_price' => 200,
                'image_url' => 'https://www.greendna.in/cdn/shop/products/greentea_1136x.jpg?v=1628922791'
            ],
            [
                'name' => 'Organic Coconut Oil',
                'description' => 'Pure and natural coconut oil',
                'original_price' => 500,
                'discounted_price' => 400,
                
                'image_url' => 'https://mamaearth.in/blog/wp-content/uploads/2022/08/coconut-oil-benefits-1200x900.jpg'
            ],
            [
                'name' => 'Organic Chia Seeds',
                'description' => 'High-quality chia seeds',
                'original_price' => 350,
                'discounted_price' => 300,
                'image_url' => 'https://cpimg.tistatic.com/07726920/b/4/Organic-Chia-Seeds.jpg'
            ],
            [
                'name' => 'Organic Quinoa',
                'description' => 'Healthy and nutritious quinoa',
                'original_price' => 500,
                'discounted_price' => 450,
                'image_url' => 'https://www.sattvicfoods.in/cdn/shop/files/OrganicQuinoaLoose.jpg?v=1714460338&width=1946'
            ],
            [
                'name' => 'Organic Flax Seeds',
                'description' => 'Rich in omega-3 fatty acids',
                'original_price' => 220,
                'discounted_price' => 180,
                'image_url' => 'https://goodfood.ae/cdn/shop/files/FLAXSEEDS.jpg?v=1690432121&width=1946'
            ]
        ];
    @endphp
    @foreach($products as $product)
        <div class="col-md-3">
            <div class="card">
                <img src="{{ $product['image_url'] }}" class="card-img-top" alt="{{ $product['name'] }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="card-text">{{ $product['description'] }}</p>
                    
                    <p class="stars">&#9733;&#9733;&#9733;&#9733;&#9734;</p>
                    <div class="price-container">
                        <p class="discount">&#x2193; {{ round((($product['original_price'] - $product['discounted_price']) / $product['original_price']) * 100) }}% OFF</p>
                        <p class="original-price">₹{{ $product['original_price'] }}</p>
                        <p class="final-price">₹{{ $product['discounted_price'] }}</p>
                    </div>
                    <p class="free-delivery">🚚 Free Delivery</p>
                    
                    <a href="#" class="btn btn-primary">View Product</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
