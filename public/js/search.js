$(document).ready(function(){
    $(document).on('submit', '#search-product-form', function(){
 
        // get search keywords
        var keywords = $(this).find(":input[name='keywords']").val();
        $.getJSON("http://localhost/rest_api/product/search.php?s=" + keywords, function(data){
 
            readProductsTemplate(data, keywords);
 
            // chage page title
            changePageTitle("Search products: " + keywords);
 
        });
 
        // prevent whole page reload
        return false;
    });
 
});