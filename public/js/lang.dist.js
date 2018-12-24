/*!
 *  Lang.js for Laravel localization in JavaScript.
 *
 *  @version 1.1.0
 *  @license MIT
 *  @site    https://github.com/rmariuzzo/Laravel-JS-Localization
 *  @author  rmariuzzo
 */'use strict';(function(root,factory){if(typeof define==='function'&&define.amd){define([],factory);}else if(typeof exports==='object'){module.exports=new(factory())();}else{root.Lang=new(factory())();}}(this,function(){var defaults={defaultLocale:'en'};var Lang=function(options){options=options||{};this.defaultLocale=options.defaultLocale||defaults.defaultLocale;};Lang.prototype.setMessages=function(messages){this.messages=messages;};Lang.prototype.get=function(key,replacements){if(!this.has(key)){return key;}
var message=this._getMessage(key,replacements);if(message===null){return key;}
if(replacements){message=this._applyReplacements(message,replacements);}
return message;};Lang.prototype.has=function(key){if(typeof key!=='string'||!this.messages){return false;}
return this._getMessage(key)!==null;};Lang.prototype.choice=function(key,count,replacements){replacements=typeof replacements!=='undefined'?replacements:{};replacements['count']=count;var message=this.get(key,replacements);if(message===null||message===undefined){return message;}
var messageParts=message.split('|');var explicitRules=[];var regex=/{\d+}\s(.+)|\[\d+,\d+\]\s(.+)|\[\d+,Inf\]\s(.+)/;for(var i=0;i<messageParts.length;i++){messageParts[i]=messageParts[i].trim();if(regex.test(messageParts[i])){var messageSpaceSplit=messageParts[i].split(/\s/);explicitRules.push(messageSpaceSplit.shift());messageParts[i]=messageSpaceSplit.join(' ');}}
if(messageParts.length===1){return message;}
for(var i=0;i<explicitRules.length;i++){if(this._testInterval(count,explicitRules[i])){return messageParts[i];}}
if(count>1){return messageParts[1];}else{return messageParts[0];}};Lang.prototype.setLocale=function(locale){this.locale=locale;};Lang.prototype.getLocale=function(){return this.locale||this.defaultLocale;};Lang.prototype._parseKey=function(key){if(typeof key!=='string'){return null;}
var segments=key.split('.');return{source:this.getLocale()+'.'+segments[0],entries:segments.slice(1)};};Lang.prototype._getMessage=function(key){key=this._parseKey(key);if(this.messages[key.source]===undefined){return null;}
var message=this.messages[key.source];while(key.entries.length&&(message=message[key.entries.shift()]));if(typeof message!=='string'){return null;}
return message;};Lang.prototype._applyReplacements=function(message,replacements){for(var replace in replacements){message=message.split(':'+replace).join(replacements[replace]);}
return message;};Lang.prototype._testInterval=function(count,interval){return false;};return Lang;}));(function(root){Lang.setMessages({"en.auth":{"login":"Login","signup":"Sign up"},"en.pagination":{"previous":"&laquo; Previous","next":"Next &raquo;"},"en.passwords":{"password":"Passwords must be at least six characters and match the confirmation.","user":"We can't find a user with that e-mail address.","token":"This password reset token is invalid.","sent":"We have e-mailed your password reset link!","reset":"Your password has been reset!"},"en.validation":{"accepted":"The :attribute must be accepted.","active_url":"The :attribute is not a valid URL.","after":"The :attribute must be a date after :date.","alpha":"The :attribute may only contain letters.","alpha_dash":"The :attribute may only contain letters, numbers, and dashes.","alpha_num":"The :attribute may only contain letters and numbers.","array":"The :attribute must be an array.","before":"The :attribute must be a date before :date.","between":{"numeric":"The :attribute must be between :min and :max.","file":"The :attribute must be between :min and :max kilobytes.","string":"The :attribute must be between :min and :max characters.","array":"The :attribute must have between :min and :max items."},"boolean":"The :attribute field must be true or false.","confirmed":"The :attribute confirmation does not match.","date":"The :attribute is not a valid date.","date_format":"The :attribute does not match the format :format.","different":"The :attribute and :other must be different.","digits":"The :attribute must be :digits digits.","digits_between":"The :attribute must be between :min and :max digits.","email":"The :attribute must be a valid email address.","filled":"The :attribute field is required.","exists":"The selected :attribute is invalid.","image":"The :attribute must be an image.","in":"The selected :attribute is invalid.","integer":"The :attribute must be an integer.","ip":"The :attribute must be a valid IP address.","max":{"numeric":"The :attribute may not be greater than :max.","file":"The :attribute may not be greater than :max kilobytes.","string":"The :attribute may not be greater than :max characters.","array":"The :attribute may not have more than :max items."},"mimes":"The :attribute must be a file of type: :values.","min":{"numeric":"The :attribute must be at least :min.","file":"The :attribute must be at least :min kilobytes.","string":"The :attribute must be at least :min characters.","array":"The :attribute must have at least :min items."},"not_in":"The selected :attribute is invalid.","numeric":"The :attribute must be a number.","regex":"The :attribute format is invalid.","required":"The :attribute field is required.","required_if":"The :attribute field is required when :other is :value.","required_with":"The :attribute field is required when :values is present.","required_with_all":"The :attribute field is required when :values is present.","required_without":"The :attribute field is required when :values is not present.","required_without_all":"The :attribute field is required when none of :values are present.","same":"The :attribute and :other must match.","size":{"numeric":"The :attribute must be :size.","file":"The :attribute must be :size kilobytes.","string":"The :attribute must be :size characters.","array":"The :attribute must contain :size items."},"unique":"The :attribute has already been taken.","url":"The :attribute format is invalid.","timezone":"The :attribute must be a valid zone.","custom":{"attribute-name":{"rule-name":"custom-message"}},"attributes":[]},"es.auth":{"login":"Iniciar Sesi\u00f3n","signup":"Contratar"},"es.pagination":{"previous":"&laquo; Previous","next":"Next &raquo;"},"es.passwords":{"password":"Passwords must be at least six characters and match the confirmation.","user":"We can't find a user with that e-mail address.","token":"This password reset token is invalid.","sent":"We have e-mailed your password reset link!","reset":"Your password has been reset!"},"es.validation":{"accepted":"The :attribute must be accepted.","active_url":"The :attribute is not a valid URL.","after":"The :attribute must be a date after :date.","alpha":"The :attribute may only contain letters.","alpha_dash":"The :attribute may only contain letters, numbers, and dashes.","alpha_num":"The :attribute may only contain letters and numbers.","array":"The :attribute must be an array.","before":"The :attribute must be a date before :date.","between":{"numeric":"The :attribute must be between :min and :max.","file":"The :attribute must be between :min and :max kilobytes.","string":"The :attribute must be between :min and :max characters.","array":"The :attribute must have between :min and :max items."},"boolean":"The :attribute field must be true or false.","confirmed":"The :attribute confirmation does not match.","date":"The :attribute is not a valid date.","date_format":"The :attribute does not match the format :format.","different":"The :attribute and :other must be different.","digits":"The :attribute must be :digits digits.","digits_between":"The :attribute must be between :min and :max digits.","email":"The :attribute must be a valid email address.","filled":"The :attribute field is required.","exists":"The selected :attribute is invalid.","image":"The :attribute must be an image.","in":"The selected :attribute is invalid.","integer":"The :attribute must be an integer.","ip":"The :attribute must be a valid IP address.","max":{"numeric":"The :attribute may not be greater than :max.","file":"The :attribute may not be greater than :max kilobytes.","string":"The :attribute may not be greater than :max characters.","array":"The :attribute may not have more than :max items."},"mimes":"The :attribute must be a file of type: :values.","min":{"numeric":"The :attribute must be at least :min.","file":"The :attribute must be at least :min kilobytes.","string":"The :attribute must be at least :min characters.","array":"The :attribute must have at least :min items."},"not_in":"The selected :attribute is invalid.","numeric":"The :attribute must be a number.","regex":"The :attribute format is invalid.","required":"The :attribute field is required.","required_if":"The :attribute field is required when :other is :value.","required_with":"The :attribute field is required when :values is present.","required_with_all":"The :attribute field is required when :values is present.","required_without":"The :attribute field is required when :values is not present.","required_without_all":"The :attribute field is required when none of :values are present.","same":"The :attribute and :other must match.","size":{"numeric":"The :attribute must be :size.","file":"The :attribute must be :size kilobytes.","string":"The :attribute must be :size characters.","array":"The :attribute must contain :size items."},"unique":"The :attribute has already been taken.","url":"The :attribute format is invalid.","timezone":"The :attribute must be a valid zone.","custom":{"attribute-name":{"rule-name":"custom-message"}},"attributes":[]},"fr.auth":{"login":"S'identifier","signup":"Signer"},"fr.pagination":{"previous":"&laquo; Previous","next":"Next &raquo;"},"fr.passwords":{"password":"Passwords must be at least six characters and match the confirmation.","user":"We can't find a user with that e-mail address.","token":"This password reset token is invalid.","sent":"We have e-mailed your password reset link!","reset":"Your password has been reset!"},"fr.validation":{"accepted":"The :attribute must be accepted.","active_url":"The :attribute is not a valid URL.","after":"The :attribute must be a date after :date.","alpha":"The :attribute may only contain letters.","alpha_dash":"The :attribute may only contain letters, numbers, and dashes.","alpha_num":"The :attribute may only contain letters and numbers.","array":"The :attribute must be an array.","before":"The :attribute must be a date before :date.","between":{"numeric":"The :attribute must be between :min and :max.","file":"The :attribute must be between :min and :max kilobytes.","string":"The :attribute must be between :min and :max characters.","array":"The :attribute must have between :min and :max items."},"boolean":"The :attribute field must be true or false.","confirmed":"The :attribute confirmation does not match.","date":"The :attribute is not a valid date.","date_format":"The :attribute does not match the format :format.","different":"The :attribute and :other must be different.","digits":"The :attribute must be :digits digits.","digits_between":"The :attribute must be between :min and :max digits.","email":"The :attribute must be a valid email address.","filled":"The :attribute field is required.","exists":"The selected :attribute is invalid.","image":"The :attribute must be an image.","in":"The selected :attribute is invalid.","integer":"The :attribute must be an integer.","ip":"The :attribute must be a valid IP address.","max":{"numeric":"The :attribute may not be greater than :max.","file":"The :attribute may not be greater than :max kilobytes.","string":"The :attribute may not be greater than :max characters.","array":"The :attribute may not have more than :max items."},"mimes":"The :attribute must be a file of type: :values.","min":{"numeric":"The :attribute must be at least :min.","file":"The :attribute must be at least :min kilobytes.","string":"The :attribute must be at least :min characters.","array":"The :attribute must have at least :min items."},"not_in":"The selected :attribute is invalid.","numeric":"The :attribute must be a number.","regex":"The :attribute format is invalid.","required":"The :attribute field is required.","required_if":"The :attribute field is required when :other is :value.","required_with":"The :attribute field is required when :values is present.","required_with_all":"The :attribute field is required when :values is present.","required_without":"The :attribute field is required when :values is not present.","required_without_all":"The :attribute field is required when none of :values are present.","same":"The :attribute and :other must match.","size":{"numeric":"The :attribute must be :size.","file":"The :attribute must be :size kilobytes.","string":"The :attribute must be :size characters.","array":"The :attribute must contain :size items."},"unique":"The :attribute has already been taken.","url":"The :attribute format is invalid.","timezone":"The :attribute must be a valid zone.","custom":{"attribute-name":{"rule-name":"custom-message"}},"attributes":[]}});})(window);