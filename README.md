# HashCryptHub
HashCryptHub is a Cryptocurrency Trading System MVP.

**FYI! It designed only for proof of concept and need some improvement for real bitcoin trading.**

## Business logic 

As a registered user you should see the list of offers to buy bitcoins with different currencies and payment methods. In addition to this list you should be able to create your own offers with custom margin and start trades with other registered users. 
## Definitions and Pre-conditions 

* Fiat - is a currency established as money by government regulation or law. Please add 4 currencies and their actual rates: EUR, USD, GPB, NGN. 
* BTC - bitcoin. 1 bitcoin is divisible up to 8 decimals (0.00000001 which is 1 satoshi). 1 bitcoin equals to 100 000 000 satoshis 
* Offer owner can create offer to sell bitcoin. 
* Offer price should not be fixed, it should be relative to the current bitcoin market price in USD. Offer price = OFFER OWNER’S MARGIN (%) * BITCOIN CURRENT MARKET PRICE (USD) * RATE OF SELECTED CURRENCY. 
* Payment methods. Amazon gift card, Walmart gift card, Paypal, Skrill, etc. (No need to implement any external integration, payment methods are just placeholders) 
* Trade status - pending, cancelled (coins returned back to seller), successful (coins sold to buyer) 
* Bitcoin market price is 3000 USD. 

### Authentication and registration (simple as possible) 
* Guests can register with email and password 
* Registered users can login with email and password 
* Logged in users can log out 
* Every registered user gets complimentary 5 BTC upon registration 

### Create/edit offer 
* Registered users can buy or sell bitcoins 
* Create add/edit offer form for selling bitcoins with fields: 
	* Fiat currency 
	* Payment method 
	* Min amount (fiat) 
	* Max amount (fiat) 
	* Margin in % (Markup) 
	* Final offer price (calculated on the fly by formula above) 

### Offers search

* Logged in user can view and search offers (only enabled) 

### Columns: 
* Offer owner 
* Payment method 
* Min/max amount in fiat 
* Price per 1 BTC in fiat 

### Search filters: 
* Amount 
* Currency 
* Payment method 
* As logged in user, should be displayed 2 additional columns: 
* Input box for a specific amount. User should be able to type amount in fiat. 
* Buy button. 
* Create new trade between buyer and seller on "Buy" button click 

## Dashboard 

* Logged in user has dashboard with his offers and trades 

* Offers have same columns as here + action buttons: 
	* Edit (link to offer edit page) 
	* Delete 
	* Disable/enable (by default all offers should be enabled, “disabled” means offer is not active and visible only for his owner) 

* List of trades (columns) 
	* Trade ID 
	* Trade partner 
	* Amount in fiat 
	* Amount in BTC 
	* Payment method 
	* Status 
	* Started at (time) 
	* Cancel and sell buttons (if status is applicable, visible only for seller)

* “Cancel” or “sell” button has been clicked by seller. Buyer doesn't have any actions in trades, only seller has. 
* Update status of the trade and transfer BTC from seller to buyer in case of “sell”. 
