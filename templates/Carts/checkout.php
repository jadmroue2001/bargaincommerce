<h2>Checkout</h2>

<!-- Stripe payment form -->
<?= $this->Form->create(null, ['url' => ['action' => 'processPayment'], 'id' => 'payment-form']) ?>
    <div id="card-element">
        <!-- Stripe's Element will be inserted here -->
    </div>
    <button type="submit">Pay</button>
<?= $this->Form->end() ?>

<script src="https://js.stripe.com/v3/"></script>
<script>
var stripe = Stripe('pk_test_51P1Ab9P838haqhnmEweYOUHOCMNMKtq2EKFiYjs4Pzgp7qQy7uP95iyzDy4ExkiIbt4Ug1OnQ0pAU6BfyHJmW9Ny008FYlA0z3');
var elements = stripe.elements();
var card = elements.create('card', {
    hidePostalCode: true // Disable the ZIP/Postal code field
});
card.mount('#card-element');

var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();

    stripe.createToken(card).then(function(result) {
        if (result.error) {
            // Display error message
            console.error(result.error.message);
        } else {
            // Send token to server with CSRF token
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', result.token.id);
            form.appendChild(hiddenInput);

            form.submit();
        }
    });
});
</script>
