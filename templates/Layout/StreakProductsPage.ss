<ul class="streak-product-list">
    <% loop $ProductList %>
    <li data-id="$ID">
        <% include StreakProduct Top=$Top %>
    </li>
    <% end_loop %>
</ul>