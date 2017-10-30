# Magento Ajax Cart Module

Lightweight Magento 1.x ajax cart module which allows easy integration into custom theme. Module does not override default validation, nor does it changes any default template, which allows for seemles integration.

**Note:** This is not a _plug 'n' play_ module. Out of the box, it does very little. It is intended to be used by developers. 

## Configuration

Ajax cart be easily enabled or disabled from system configuration – `System -> Configuration -> Checkout -> Shopping Cart`

![Ajax Cart Configuration](https://s3-eu-west-1.amazonaws.com/stcd/stunt_mage_ajax_cart/config.png)

## Integration

Custom events are triggered on document object before ajax request is sent and after response has been returned. These events should be used to update UI.

```js
document.addEventListener('sc_ajax_cart_add_before', function (e) {
    console.log(e.detail); // { form: [Product Form Object] }
});

document.addEventListener('sc_ajax_cart_add_after', function (e) {
    console.log(e.detail); // { form: [Product Form Object], response: [XMLHttpRequest Object] }
    console.log(e.detail.response.responseJSON); // { success: [true|false], message: [Add to cart message] }
});
```

Copyright StuntCoders — [Start Your Online Store Now](https://stuntcoders.com/)
