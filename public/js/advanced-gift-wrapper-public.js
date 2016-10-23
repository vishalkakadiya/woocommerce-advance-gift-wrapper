/**
 * This is an pure JAVASCRIPT file, and used to validate gift-wrap's form which 
 * is displaying at the end of woocommerce cart page. Validating all fields and
 * display proper error message to end users.
 *
 * @summary Used to validate form. 
 *
 * @since 1.0.0
 */


// Declare variables;
var formElement, formError, toField, toError, messageField, 
    messageError, fromField, fromError, flag;

/**
 * @summary Executes when document is completed with load.
 *
 * Adding 'DOMContentLoaded' event to document, so that function's 
 * executes after document is fully loaded. It is populating HTML 
 * element DOM object to global variables.
 *
 * @since 1.0.0
 * 
 * @fires document:DOMContentLoaded
 */
document.addEventListener('DOMContentLoaded', function() {

	/**
	 * Caching DOM elements to global variables, which can be used
	 * by other functions, so they don't need to search HTML elements 
	 * every time in particular document.
	 */
	formElement = document.getElementById('agw-gift-shop-form');
	formError = document.getElementById('agw-gift-type-error');

	toField = document.getElementById( 'agw-to-field' );
	toError = document.getElementById( 'agw-to-error' );

	messageField = document.getElementById( 'agw-message-field' );
	messageError = document.getElementById( 'agw-message-error' );

	fromField = document.getElementById( 'agw-from-field' );
	fromError = document.getElementById( 'agw-from-error' );

}, false);

/**
 * @summary Executes when form's submit button is clicked.
 *
 * This is an Gift Wrapper form validation function which is displaying 
 * at the end of woocommerce cart page. . Internally call other fuctions also.
 *
 * @since 1.0.0
 *
 * @see getRadioVal()
 * @see checkFormFields()
 * @global boolean flag Form submission is depends on this variable's value.
 *
 * @return boolean flag If all fields is valid then return true otherwise return false.
 *						Default is global value.
 */
function agwValidateGiftForm() {

	flag = true; // Initially we assumming no error.

	var radioSelectedValue = getRadioVal( formElement, 'vk_agw_wrap_type_id' );

	checkFormFields( radioSelectedValue, formError, 'Please select any one gift wrapper from above!' );
	checkFormFields( toField.value, toError, 'Please provide receiver name!' );
	checkFormFields( messageField.value, messageError, 'Please add some message for receiver!' );
	checkFormFields( fromField.value, fromError, 'Please provide sender name!' );

    return flag;
}

/**
 * @summary Checks radio button is checked or not.
 *
 * Check if any radio button is selected then return it's value otherwise
 * return empty string.
 *
 * @since 1.0.0
 * 
 * @link http://www.dyn-web.com/tutorials/forms/radio/get-selected.php
 *
 * @param HTML-Element It is a "form tag".
 * @param string name Value of radio button's name attribute.
 * @return int/string val Value of checked radio or empty string if none checked, 
 *                  Default is empty string.
 */
function getRadioVal( form, name ) {
    var val = '';
    // get list of radio buttons with specified name
    var radios = form.elements[name];
    
    // loop through list of radio buttons
    for ( var i = 0, len = radios.length; i < len; i++) {
        if ( radios[ i ].checked ) { // radio checked?
            val = radios[ i ].value; // if so, hold its value in val
            break; // and break out of for loop
        }
    }
    return val;
}

/**
 * @summary Checks variable is empty string or not, if empty then adding error message.
 *
 * Check if given parameter(formElementValue) value is empty string or not, 
 * if empty then add proper message(errorMessage) to related HTML element(errorElement)
 * and assign global variable flag to false.
 *
 * @since 1.0.0
 *
 * @global boolean flag Form submission is depends on this variable's value.
 *
 * @param int/string formElementValue Value which needs to check against empty-string.
 * @param HTML-Element errorElement Element in which error message is append.
 * @param string Value errorMessage Message which is going to append in errorElement. 
 */
function checkFormFields( formElementValue, errorElement, errorMessage ) {
	if ( '' == formElementValue ) {
		errorElement.innerText = errorMessage;
		flag = false;
	}
}