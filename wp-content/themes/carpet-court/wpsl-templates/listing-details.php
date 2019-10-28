<?php ob_start(); ?>

    <div class="store-details" style="display: none;">
        <div class="app-filter-result__flex-box">
            <div class="app-filter-result__detail-title app-filter-result__detail-vi">
                <img src="<%= retailer_image %>" alt="<%= store %>">
                <a href="" class="app-modal-close"></a>
            </div>
            <div class="app-filter-result__detail-item app-filter-result__detail-vi" itemscope itemtype="http://schema.org/LocalBusiness">
                <div class="app-filter-result__detail-item-title"><span>Address</span></div>

                <meta itemprop="name" content="<%= store %>">
                <div class="app-filter-result__detail-address">
                    <div class="_left" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                        <span ><%= store %></span><br/> 
                        <span itemprop="streetAddress"><%= address %></span>, <span itemprop="addressLocality"><%= city %></span>, <%= country %> <br/> <% if (phone){ %> Phone:
                        <a href="tel:<%= phone %>"><span itemprop="telephone"><%= phone %></span></a> <% } %>
                    </div>
                </div>
                <div class="app-filter-result__action-block">
                    <% if(phone){ %>
                        <a href="tel:<%= phone %>" class="shop-deal-btn" data-name="">call store</a>
                    <% } %>
                    <a href="http://maps.google.com/maps?daddr=<%= address %>,<%= city %>,<%= country %>&saddr=" target="_blank" class="app-button-reserve _inline get-direction">Get directions</a>
                    <a href="http://maps.google.com/maps?daddr=<%= address %>,<%= city %>,<%= country %>&saddr=" target="_blank" class="app-button-reserve _inline get-direction-mobile">Get directions</a>
                </div>
            </div>
            <% if(offers){ %>
            <% if(offers.length == 1) { %>
            <div class="">
                <div class="">
            <% } else { %>
            <div class="app-filter-result__flex-scroll">
                <div class="app-filter-result__scroll">
            <% } %>
                    <div class="app-scrollbar">
                        <div class="available-deals">
                            <div class="deals-block-title">
                                Available Deals
                            </div>
                        <% for(var i in offers) { %>
                            <div class="deals-content">
                                <div class="deal-content-title">
                                    <% if(offers[i].hot) { %>
                                        <img src="<?= get_stylesheet_directory_uri(); ?>/img/deal-star-dollar.svg">
                                    <% } %>
                                    <%= offers[i].title %>
                                </div>
                                <% if(offers[i].sub_title){ %>
                                <div class="deal-content-subtitle">
                                    <%= offers[i].sub_title %>
                                </div>
                                <% } %>
                                <div class="deal-content-text">
                                    <%= offers[i].excerpt %>
                                </div>
                                <div class="deal-content-action">
                                    <% if(retailer_url[offers[i].id]) { %>
                                        <a href="<%= retailer_url[offers[i].id] %>" target="_blank" class="ga-link  shop-deal-btn shop-deal-btn-cta" data-name="<%= offers[i].name %>"><%= offers[i].cta_button %></a>
                                    <% } else { %>
                                        <a href="<%= retailer_url %>" class="ga-link shop-deal-btn shop-deal-btn-cta" data-name="<%= offers[i].name %>"><%= offers[i].cta_button %></a>
                                    <% } %>
                                    <span class="deal-expiry-date">Offer ends <%= offers[i].ends %></span>
                                </div>
                            </div>
                        <% } %>
                        <% if ( twist ) { %>
                        <div class="app-filter-result__detail-banner app-filter-result__detail-vi">
                            <div class="_absolute-bg app-inline-bg" style="background-image: url(<% if ( twist.image ) { %><%= twist.image %><% } %><% if ( !twist.image ) { %><?= get_stylesheet_directory_uri(); ?>/img/detail-banner-bg.jpg<% } %>)"></div>
                            <div class="_absolute-bg app-inline-bg _blury-bg"></div>
                            <div class="app-filter-result__detail-banner-inner">
                                <div class="page-h3"><%= twist.post_title %></div>
                                <div class="page-subtitle"><%= twist.post_content %></div>
                            </div>
                        </div>
                            <% if ( twist_benefits ) { %>
                            <div class="app-filter-result__detail-item app-filter-result__detail-vi">
                                <div class="app-filter-result__detail-item-title" style="line-height: 21px;">
                                    <% if ( twist.benefits_title ) { %>
                                    <span><%= twist.benefits_title %></span>
                                    <% } %>
                                    <% if ( !twist.benefits_title ) { %>
                                    <span>How <%= twist.post_title %> will improve your sleep</span>
                                    <% } %>
                                </div>
                                <% for(var i in twist_benefits) { %>
                                <div class="app-filter-result__detail-info">
                                    <div class="_left"><span class="app-filter-result__detail-info-title"><%= twist_benefits[i].post_title %></span>
                                    </div>
                                    <div class="_right">
                                        <% if ( twist_benefits[i].info ) { %>
                                        <div class="_sinfo"><%= twist_benefits[i].info %></div>
                                        <% } %>
                                        <div><%= twist_benefits[i].post_content %></div>
                                    </div>
                                </div>
                                <% } %>
                            </div>
                            <% } %>
                        <% } %>
                        <% if ( base_twist ) { %>
                        <div class="app-filter-result__detail-banner app-filter-result__detail-vi">
                            <div class="_absolute-bg app-inline-bg" style="background-image: url(<% if ( base_twist.image ) { %><%= base_twist.image %><% } %><% if ( !base_twist.image ) { %><?= get_stylesheet_directory_uri(); ?>/img/detail-banner-bg.jpg<% } %>)"></div>
                            <div class="_absolute-bg app-inline-bg _blury-bg"></div>
                            <div class="app-filter-result__detail-banner-inner">
                                <div class="page-h3"><%= base_twist.post_title %></div>
                                <div class="page-subtitle"><%= base_twist.post_content %></div>
                            </div>
                        </div>
                            <% if ( base_benefits ) { %>
                            <div class="app-filter-result__detail-item app-filter-result__detail-vi">
                                <div class="app-filter-result__detail-item-title" style="line-height: 21px;">
                                    <span><%= base_twist.benefits_title %></span>
                                </div>
                                <% for(var i in base_benefits) { %>
                                <div class="app-filter-result__detail-info">
                                    <div class="_left"><span class="app-filter-result__detail-info-title"><%= base_benefits[i].post_title %></span>
                                    </div>
                                    <div class="_right">
                                        <% if ( base_benefits[i].info ) { %>
                                        <div class="_sinfo"><%= base_benefits[i].info %></div>
                                        <% } %>
                                        <div><%= base_benefits[i].post_content %></div>
                                    </div>
                                </div>
                                <% } %>
                            </div>
                            <% } %>
                        <% } %>
                        
                        
                        <div class="app-filter-result__detail-item-tools app-filter-result__detail-vi" style="display: none;">
                            <a href="" class="app-button-submit"><span class="_icon-left"><img src="<?= get_stylesheet_directory_uri(); ?>/svg/mobile-menu-mail.svg" alt=""></span> Email results
                            </a>
                            <a href="" class="_link">And get the latest Hot Deals</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <% } %>

            <% if(ranges_show) { %>
                <% if(ranges.length > 0) { %>
                <div class="deal-stores">
                    <div class="stores-title">
                        Mattress Ranges In-Store
                    </div>
                    <ul class="deal-store-list">
                        <% for(var i in ranges) { %>
                            <li><a href="<%= ranges[i].link %>" class="ga-link " title="<%= ranges[i].title %>"><%= ranges[i].title %></a></li>
                        <% } %>
                    </ul>
                </div>
                <% } %>
            <% } %>
        </div>
    </div>
<?php return ob_get_clean(); ?>