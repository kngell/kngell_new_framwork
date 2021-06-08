class ProductDetail {
  constructor() {}

  init() {
    this._applyProductGallery();
    this._applyProductColor();
    this._applyProductSize();
  }

  _applyProductGallery = () => {
    $('.product-gallery-item').on('click', function(){
      let imgUrl = $(this).find('img').attr('src');
      $('#product-img').attr('src', imgUrl);
      $(this).parent().find('.product-gallery-item.active').removeClass('active');
      $(this).addClass('active');
    });
  }

  _applyProductColor = () => {
    $('.product-color-list-item').on('click', function(){
      $(this).parent().find('.product-color-list-item.active').removeClass('active');
      $(this).addClass('active');
    });
  }

  _applyProductSize = () => {
    $('.product-size-list-item').on('click', function(){
      $(this).parent().find('.product-size-list-item.active').removeClass('active');
      $(this).addClass('active');
    });
  }
}
new ProductDetail().init()