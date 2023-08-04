require('./bootstrap');

import AdyenCheckout from '@adyen/adyen-web';
import '@adyen/adyen-web/dist/adyen.css';

const configuration = {
    'environment': 'test',
    'clientKey': 'test_VDKU4GEMBFAZJLAOAJEVTPDGHI73FBSM',
    'paymentMethods': {
        0: {
            "brands": {
                0: "visa",
                1: "mc",
            },
            "name": "Credit Card",
            "type": "card"
        }
    },
     analytics: {
         enabled: true
     },
    // session: {
    //     id: 'CSD1CFE1D070CDF4E7', // Unique identifier for the payment session.
    //     sessionData: "Ab02b4c0!BQABAgAC3qjCu5JUCsRZM3xFdUMWUD8JZtflqjfwqunjM7cGmQTe8tKdIP8RbZ40a+VkzrUxsKqcUghxw936fdS+Jp1G3X4FtuKsXsJ/WEXGgwhWZLzOFKRXm+aNL7VXHlmvrJBA+rTHwj+yGe7fhIaU3Vc6Y6eG8Xmt52UKU6lC3tMLNfnqijyMEofPG8CZXPmEyo1ToBo0SOFM+neu26ndmtgonkoW3B6c5hjthyCvR2hpylKFVcm5DEOFR0HL83ptxIwM9LbRKGHNjYAmovEh0or+7XqqA589QoPOEHVGWpp1rUrawjnHh7nFpACg0YQQU2e/+5m8YDIFiDQGVb9LQoqBeTfvTxkNsdpl8YSUDIHGlGpctGCJ82PGCeVwDFnd25GBj1R++QNi2Mzd8SRVHinycfUJg6Pv9DmnRErWbpHD5vebxjTfiyj2wmU36pRWXJnjHJ5jb+YcAVp+9Eqhgm/AQe6nBhwiEIRl7/q/u9yeqoxzitf7AnWg5xSyDP/BGgVsJwGiiIWOqhT+hRn0Poe66hkDjNeRtQIWNh63z4eZN8SExgSuHZ32d8kr8RZmGQAuRgY5kTyMR6jHs5bbKOwresQgtO/UtE+U2OOQfYEIfqQ3S6fZeiMwGNG+dDCqxGeV08ZnK3SOIggnmT84zB15cgAC4+BWSYXzd4x/5bNFoQzyzUbM8F7o6pbJAVsASnsia2V5IjoiQUYwQUFBMTAzQ0E1MzdFQUVEODdDMjRERDUzOTA5QjgwQTc4QTkyM0UzODIzRDY4REFDQzk0QjlGRjgzMDVEQyJ9RaDYgzG9DEP4VgwWZREMN7yWhMqE5Pe/gbWQHMQfHIA2zbui544x9mCd1l8CT07D8iKUHTpFq/fsYLfEH8zuGE5ggdbwyhVhbsKBCY1kKoomztZlcLTIFonQ39+MXQdgBuqiTE0qG7nz467ggUKOSF+EwPoQeI6sM/6JSqAsStsTcCwUKeZltXU44PL+bvbGthPsSEr6wRtR4P+3/phxsp0WFfHEX6yVWUIWEm/Q9oQo7n6ocN9V7gzxjfsATcAjtcr7ZiKu1j/iv6d4EtSBq3q2Z3o7ITSgtb2ywS3t6DCe3MZ3ZlQ6k5q+KoN3Htg12B1gAiur3E9njRxNtWZNaRXK0If+i41uiisYPr9nJoOQqrwbdVBphw9EF3f3O583CTcXbQFh4V3PTDg25YdY1krYs4GPMiJQtfI6Y3xkTEuGD2HgMMwvPF010hJy9Sn65EGdkjuaQ3PmwPLFHU59h6qs+mvT96ksHkowO6tNfWQNTtcznS8aIgvex+8X2EKBvYb4GYCmFNaa7bPPXn8+IDGUGpV8hSuUKvDDCdXDlYdOvGz1WDwbZiMxf0CcCJcHhSYl4r7uiupS4+cNB+b2hDyxmqBFidMdTHDjifxx20gCNxg5KpaDBWgOn7PWYa5HecZwgV4kS6JJ4Lot+Kk=" // The payment session data.
    // },
     onPaymentCompleted: (result, component) => {
         console.info(result, component);
     },
     onError: (error, component) => {
         console.error(error.name, error.message, error.stack, component);
     },
    paymentMethodsConfiguration: {
        card: {
            hasHolderName: true,
                holderNameRequired: true,
                billingAddressRequired: false
        }
    }

};

const checkout = await AdyenCheckout(configuration);

const cardComponent = checkout.create('card', {
    showPayButton: true
}).mount('#card-container');

   // cardComponent.addEventListener('click', (event) => {
   //     console.log('Card Component focused:', event);
   // });

// const customCard = checkout.create('securedfields', {
    // type: 'card',
    // brands: ['mc', 'visa', 'amex', 'bcmc', 'maestro'],
    // styles: {
    //     error: {
    //         color: 'red'
    //     },
    //     validated: {
    //         color: 'green'
    //     },
    //     placeholder: {
    //         color: '#d8d8d8'
    //     }
    // },
    // ariaLabels: {
    //     lang: 'en-GB',
    //     encryptedCardNumber: {
    //         label: 'Credit or debit card number field',
    //         iframeTitle: 'Iframe for secured card number',
    //         error: 'Message that gets read out when the field is in the error state'
    //     }
    // },
//    Events
    // onChange: function() {},
    // onValid : function() {},
    // onLoad: function() {},
    // onConfigSuccess: function() {},
    // onFieldValid : function() {},
    // onBrand: function() {},
    // onError: function() {},
    // onFocus: function() {},
    // onBinValue: function(bin) {},
    // onBinLookup: function(callbackObj: CbObjOnBinLookup) {}
// }).mount('#dropin-container');

