@extends('layouts.user.app')

@section('content')
<section class="about-page">
    <!-- Hero Header -->
    <div class="hero-header">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Welcome to Bachat Booklet 2026</h1>
            <p class="hero-subtitle-1">Welcome aboard to the Bachat Booklet Edition 2026!
</p>
            <p class="hero-subtitle">Your ultimate guide to savings, fun, and lifestyle benefits all in one place!</p>
        </div>
    </div>

    <!-- Mission Statement -->
    <div class="container mission-section">
        <div class="mission-content">
            <div class="mission-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <h2>Our Mission</h2>
            <p class="lead-text">To help you <strong>spend smart, save more, and live better!</strong></p>
            <p>Enjoy Buy One Get One Free coupons and amazing discounts across Food, Fashion, Beauty, Fitness,
Health, Retail, and Entertainment, featuring the most loved outlets in Islamabad & Rawalpindi.</p>

<p>With over 150 exclusive coupons from 50+ top brands, Bachat Booklet 2026 offers you savings of up
to Rs. 300,000 throughout the year. Whether you’re a foodie, a shopper, or a beauty lover, we’ve got
the perfect offers waiting for you from fine dining and cafés to salons, gyms, attractions, and more.
</p>
        </div>
    </div>

    <!-- Value Proposition -->
    <div class="value-prop-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">150+</div>
                    <div class="stat-label">Exclusive Coupons</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Top Brands</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">Rs. 300K</div>
                    <div class="stat-label">Potential Savings</div>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="container how-it-works-section">
        <h2 class="section-title">How to Redeem Your Coupon</h2>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Select</h3>
                <p>Choose your desired coupon from the booklet</p>
            </div>
            <div class="step-card">
                <div class="step-number">2</div>
                <h3>Present</h3>
                <p>Show it to the staff before placing your order</p>
            </div>
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Enjoy</h3>
                <p>Redeem and enjoy instant savings Once redeemed, the coupon is considered used and cannot be reused</p>
            </div>
        </div>
    </div>

    <!-- Rules Section -->
    <div class="rules-section">
        <div class="container">
            <h2 class="section-title">Rules of Use</h2>
            <div class="rules-grid">
                <div class="rule-item">
                    <p>Please read all instructions on each coupon carefully before use</p>
                </div>
                <div class="rule-item">
                    <p>Coupons are valid until December 30, 2026, unless otherwise specified</p>
                </div>
                <div class="rule-item">           
                    <p>Coupons are non-transferable and void if sold, exchanged, copied, or reproduced</p>
                </div>
                <div class="rule-item">                  
                    <p>Coupons apply only to the items and conditions mentioned</p>
                </div>
                <div class="rule-item">  
                    <p>Not valid with any other discounts, loyalty programs, or promotions</p>
                </div>
                <div class="rule-item">  
                    <p>All dining coupons are valid for dine-in and takeaway only, unless otherwise stated</p>
                </div>
                <div class="rule-item">
                    <p>One coupon per table — a maximum of 2 coupons may be redeemed at one time for 4–6 people</p>
                </div>
                <div class="rule-item">
                    <p>The lower-priced main course or item will be complimentary in Buy One Get One Free coupons</p>
                </div>
                <div class="rule-item">
                    <p>Coupons can be redeemed any day during the merchant's operating hours, unless otherwise noted</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Exclusion Days -->
    <div class="container exclusion-section">
        <h2 class="section-title">Exclusion Days</h2>
        <p class="section-intro">Coupons are not valid on the following days or on any other public holidays as announced by the government or at the merchant's discretion:</p>
        <div class="exclusion-grid">
            <div class="exclusion-item">New Year's Eve & New Year's Day</div>
            <div class="exclusion-item">Pakistan Day</div>
            <div class="exclusion-item">Labour Day</div>
            <div class="exclusion-item">Independence Day</div>
            <div class="exclusion-item">Defence Day</div>
            <div class="exclusion-item">Eid-ul-Fitr (3 days)</div>
            <div class="exclusion-item">Eid-ul-Adha (3 days)</div>
            <div class="exclusion-item">Iqbal Day</div>
            <div class="exclusion-item">Quaid-e-Azam Day</div>
            <div class="exclusion-item">Valentine's Day</div>
            <div class="exclusion-item">Kashmir Day</div>
        </div>
    </div>

    <!-- Policies Section -->
    <div class="policies-section">
        <div class="container">
            <div class="policy-cards">
                <!-- Friends & Family -->
                <div class="policy-card">
                    <h3>Friends & Family Policy</h3>
                    <ul>
                        <li>One Coupon for 2 people</li>
                        <li>A maximum of 4–6 people can redeem 2 coupons at a time</li>
                        <li>The least priced main course will be complimentary in Buy One Get One Free coupons</li>
                        <li>Please present your coupon prior to ordering and inform the waiter or service agent that you're using Bachat Booklet</li>
                    </ul>
                </div>

                <!-- Takeaway & Delivery -->
                <div class="policy-card">
                    <h3> Takeaway & Delivery</h3>
                    <ul>
                        <li>All dining coupons are valid for dine-in and takeaway only, unless otherwise mentioned</li>
                        <li>Coupons are not valid for delivery, unless specifically stated on the coupon</li>
                    </ul>
                </div>

                <!-- Other Deals -->
                <div class="policy-card">
                    <h3> Not Valid in Conjunction with Other Deals</h3>
                    <ul>
                        <li>Coupons are exclusive and cannot be combined with any other discount, promotion, special menu, loyalty, employee, or rewards program</li>
                        <li>Coupons are not valid for buffets, special events, set menus, or theme nights unless specified</li>
                        <li>Discounts do not apply to service charges</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Disclaimer -->
    <div class="disclaimer-section">
        <div class="container">
            <h2 class="section-title">Trademark & Disclaimer</h2>
            <div class="disclaimer-content">
                <p>The sale, resale, barter, or unauthorized distribution of the Bachat Booklet or its contents is strictly prohibited. All coupons are intended for personal, non-commercial use only.</p>
                
                <p>Reproduction of any coupon or content without written consent from Bachat Booklet will render it void.</p>
                
                <p>Bachat Booklet will not be responsible for the closure, change of ownership, or refusal of any merchant to accept a coupon. However, every effort will be made to resolve such issues where possible.</p>
                
                <p>The Bachat Booklet will not be held liable for circumstances beyond its control (including acts of God, fire, illness, or government restrictions) that prevent you from using a coupon.</p>
                
                <p class="copyright">All rights reserved © Bachat Booklet 2026</p>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="cta-section">
        <div class="container">
            <h2>Spend Smart. Save More. Live Better.</h2>
            <p>With Bachat Booklet 2026!</p>
            <a href="{{ route('contact') }}" class="cta-button">Contact Us Today</a>
        </div>
    </div>
</section>
@endsection