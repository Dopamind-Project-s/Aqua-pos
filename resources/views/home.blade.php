@extends('layouts.app')

@section('content')
@php($showCarousel = true)

<section id="inventory" class="container-fluid aqua-inventory py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="aqua-pill">Inventory Management</div>
                <h2 class="display-4 text-dark mb-3">Managing Stock For Multiple Branches</h2>
                <p class="lead mb-3">Improving The Efficiency of Inventory Operations</p>
                <p class="mb-4">Reduce stock out, speed up operation, optimize routes &amp; get real-time visibility with Aqua inventory management.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">Book Demo</a>
                    <a href="#" class="btn btn-outline-primary rounded-pill py-3 px-5">View POS Modules</a>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <div class="aqua-stat-card">
                    <h5 class="mb-3">AQUA <span class="brand-pos">POS</span> Inventory Software</h5>
                    <ul class="list-unstyled mb-0">
                        <li><i class="fas fa-check-circle text-primary me-2"></i>Real-time branch stock tracking</li>
                        <li><i class="fas fa-check-circle text-primary me-2"></i>Smart reorder and transfer workflows</li>
                        <li><i class="fas fa-check-circle text-primary me-2"></i>Connected with sales and accounting</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container-fluid py-5 bg-light">
    <div class="container py-4">
        <div class="section-title mb-5 text-center wow fadeInUp" data-wow-delay="0.1s">
            <h3 class="display-6 mb-3">Inventory Management Features</h3>
            <p>Built for operational clarity, faster service and stronger branch-level control.</p>
        </div>
        <div class="row g-4">
            @php
                $features = [
                    'Improve overall inventory visibility',
                    'Connect sales with inventory levels',
                    'Comprehensive overview of current stock, available stock & reserved stock',
                    'Check actual VS expected stock levels',
                    'Speed up production & optimize storage',
                    'Reduce human errors',
                    'Improve data accuracy',
                    'Reduce costs & improve efficiency',
                    'Determine optimal redistribution timing',
                ];
            @endphp

            @foreach($features as $feature)
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="aqua-feature-card h-100">
                        <div class="aqua-feature-icon"><i class="fas fa-layer-group"></i></div>
                        <p class="mb-0">{{ $feature }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="container-fluid py-5">
    <div class="container py-4 wow fadeInUp" data-wow-delay="0.2s">
        <div class="aqua-cta text-center">
            <h3 class="text-white mb-3">Need a modern <span class="brand-pos">POS</span> &amp; Inventory platform?</h3>
            <p class="text-white-50 mb-4">Launch AQUA POS across restaurant or retail branches with confidence.</p>
            <a href="mailto:sales@aqua-pos.com" class="btn btn-light rounded-pill px-5 py-3">Contact Sales</a>
        </div>
    </div>
</section>
@endsection
