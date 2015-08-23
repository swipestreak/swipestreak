<% if $ClassName == 'Product' %>
<%-- TODO: this should only show if there is a cart --%>
<li><a href="/cart"><% _t('Cart.MenuTitle', 'Your Cart') %></a></li>
<% end_if %>
<% if $ClassName == 'StreakProductsPage' %>
<li><a href="/cart"><% _t('Cart.MenuTitle', 'Your Cart') %></a></li>
<% end_if %>
