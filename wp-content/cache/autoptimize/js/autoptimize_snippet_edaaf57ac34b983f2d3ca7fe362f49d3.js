function gformBindFormatPricingFields(){jQuery(".ginput_amount, .ginput_donation_amount").bind("change",function(){gformFormatPricingField(this)}),jQuery(".ginput_amount, .ginput_donation_amount").each(function(){gformFormatPricingField(this)})}function Currency(a){this.currency=a,this.toNumber=function(a){return this.isNumeric(a)?parseFloat(a):gformCleanNumber(a,this.currency.symbol_right,this.currency.symbol_left,this.currency.decimal_separator)},this.toMoney=function(a,b){if(b=b||!1,b||(a=gformCleanNumber(a,this.currency.symbol_right,this.currency.symbol_left,this.currency.decimal_separator)),!1===a)return"";a+="",negative="","-"==a[0]&&(a=parseFloat(a.substr(1)),negative="-"),money=this.numberFormat(a,this.currency.decimals,this.currency.decimal_separator,this.currency.thousand_separator),"0.00"==money&&(negative="");var c=this.currency.symbol_left?this.currency.symbol_left+this.currency.symbol_padding:"",d=this.currency.symbol_right?this.currency.symbol_padding+this.currency.symbol_right:"";return money=negative+this.htmlDecode(c)+money+this.htmlDecode(d),money},this.numberFormat=function(a,b,c,d,e){var e=void 0===e;a=(a+"").replace(",","").replace(" ","");var f=isFinite(+a)?+a:0,g=isFinite(+b)?Math.abs(b):0,h=void 0===d?",":d,i=void 0===c?".":c,j="",k=function(a,b){var c=Math.pow(10,b);return""+Math.round(a*c)/c};return"0"==b?(f+=1e-10,j=(""+Math.round(f)).split(".")):-1==b?j=(""+f).split("."):(f+=1e-10,j=k(f,g).split(".")),j[0].length>3&&(j[0]=j[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,h)),e&&(j[1]||"").length<g&&(j[1]=j[1]||"",j[1]+=new Array(g-j[1].length+1).join("0")),j.join(i)},this.isNumeric=function(a){return gformIsNumber(a)},this.htmlDecode=function(a){var b,c,d=a,e=d.match(/&#[0-9]{1,5};/g);if(null!=e)for(var f=0;f<e.length;f++)c=e[f],b=c.substring(2,c.length-1),d=b>=-32768&&b<=65535?d.replace(c,String.fromCharCode(b)):d.replace(c,"");return d}}function gformCleanNumber(a,b,c,d){var e="",f="",g="",h=!1;a+=" ",a=a.replace(/&.*?;/g,""),a=a.replace(b,""),a=a.replace(c,"");for(var i=0;i<a.length;i++)g=a.substr(i,1),parseInt(g)>=0&&parseInt(g)<=9||g==d?e+=g:"-"==g&&(h=!0);for(var i=0;i<e.length;i++)g=e.substr(i,1),g>="0"&&g<="9"?f+=g:g==d&&(f+=".");return h&&(f="-"+f),!!gformIsNumber(f)&&parseFloat(f)}function gformGetDecimalSeparator(a){var b;switch(a){case"currency":b=new Currency(gf_global.gf_currency_config).currency.decimal_separator;break;case"decimal_comma":b=",";break;default:b="."}return b}function gformIsNumber(a){return!isNaN(parseFloat(a))&&isFinite(a)}function gformIsNumeric(a,b){switch(b){case"decimal_dot":var c=new RegExp("^(-?[0-9]{1,3}(?:,?[0-9]{3})*(?:.[0-9]+)?)$");return c.test(a);case"decimal_comma":var c=new RegExp("^(-?[0-9]{1,3}(?:.?[0-9]{3})*(?:,[0-9]+)?)$");return c.test(a)}return!1}function gformDeleteUploadedFile(a,b,c){var d=jQuery("#field_"+a+"_"+b),e=jQuery(c).parent().index();d.find(".ginput_preview").eq(e).remove(),d.find('input[type="file"],.validation_message,#extensions_message_'+a+"_"+b).removeClass("gform_hidden"),d.find(".ginput_post_image_file").show(),d.find('input[type="text"]').val("");var f=jQuery("#gform_uploaded_files_"+a).val();if(f){var g=jQuery.secureEvalJSON(f);if(g){var h="input_"+b,i=d.find("#gform_multifile_upload_"+a+"_"+b);if(i.length>0){g[h].splice(e,1);var j=i.data("settings"),k=j.gf_vars.max_files;jQuery("#"+j.gf_vars.message_id).html(""),g[h].length<k&&gfMultiFileUploader.toggleDisabled(j,!1)}else g[h]=null;jQuery("#gform_uploaded_files_"+a).val(jQuery.toJSON(g))}}}function gformIsHidden(a){return"none"==a.parents(".gfield").not(".gfield_hidden_product").css("display")}function gformCalculateTotalPrice(a){if(_gformPriceFields[a]){var b=0;_anyProductSelected=!1;for(var c=0;c<_gformPriceFields[a].length;c++)b+=gformCalculateProductPrice(a,_gformPriceFields[a][c]);if(_anyProductSelected){b+=gformGetShippingPrice(a)}window.gform_product_total&&(b=window.gform_product_total(a,b)),b=gform.applyFilters("gform_product_total",b,a);var d=jQuery(".ginput_total_"+a);if(d.length>0){var e=d.next().val(),f=gformFormatMoney(b,!0);e!=b&&d.next().val(b).change(),f!=d.first().text()&&d.html(f)}}}function gformGetShippingPrice(a){var b=jQuery(".gfield_shipping_"+a+' input[type="hidden"], .gfield_shipping_'+a+" select, .gfield_shipping_"+a+" input:checked"),c=0;return 1!=b.length||gformIsHidden(b)||(c=b.attr("type")&&"hidden"==b.attr("type").toLowerCase()?b.val():gformGetPrice(b.val())),gformToNumber(c)}function gformGetFieldId(a){var b=jQuery(a).attr("id"),c=b.split("_");return c.length<=0?0:c[c.length-1]}function gformCalculateProductPrice(a,b){var c="_"+a+"_"+b;jQuery(".gfield_option"+c+", .gfield_shipping_"+a).find("select").each(function(){var b=jQuery(this),c=gformGetPrice(b.val()),d=b.attr("id").split("_")[2];b.children("option").each(function(){var b=jQuery(this),e=gformGetOptionLabel(b,b.val(),c,a,d);b.html(e)}),b.trigger("chosen:updated")}),jQuery(".gfield_option"+c).find(".gfield_checkbox").find("input:checkbox").each(function(){var b=jQuery(this),c=b.attr("id"),d=c.split("_")[2],e=c.replace("choice_","#label_"),f=jQuery(e),g=gformGetOptionLabel(f,b.val(),0,a,d);f.html(g)}),jQuery(".gfield_option"+c+", .gfield_shipping_"+a).find(".gfield_radio").each(function(){var b=0,c=jQuery(this),d=c.attr("id"),e=d.split("_")[2],f=c.find("input:radio:checked").val();f&&(b=gformGetPrice(f)),c.find("input:radio").each(function(){var c=jQuery(this),d=c.attr("id").replace("choice_","#label_"),f=jQuery(d);if(f){var g=gformGetOptionLabel(f,c.val(),b,a,e);f.html(g)}})});var d=gformGetBasePrice(a,b),e=gformGetProductQuantity(a,b);return e>0&&(jQuery(".gfield_option"+c).find("input:checked, select").each(function(){gformIsHidden(jQuery(this))||(d+=gformGetPrice(jQuery(this).val()))}),_anyProductSelected=!0),d*=e,d=Math.round(100*d)/100}function gformGetProductQuantity(a,b){if(!gformIsProductSelected(a,b))return 0;var c,d,e=jQuery("#ginput_quantity_"+a+"_"+b);if(e.length>0)c=e.val();else if(e=jQuery(".gfield_quantity_"+a+"_"+b+" :input"),c=1,e.length>0){c=e.val();var f=e.attr("id"),g=gf_get_input_id_by_html_id(f);d=gf_get_field_number_format(g,a,"value")}return d||(d="currency"),c=gformCleanNumber(c,"","",gformGetDecimalSeparator(d)),c||(c=0),c}function gformIsProductSelected(a,b){var c="_"+a+"_"+b,d=jQuery("#ginput_base_price"+c+", .gfield_donation"+c+' input[type="text"], .gfield_product'+c+" .ginput_amount");return!(!d.val()||gformIsHidden(d))||(d=jQuery(".gfield_product"+c+" select, .gfield_product"+c+" input:checked, .gfield_donation"+c+" select, .gfield_donation"+c+" input:checked"),!(!d.val()||gformIsHidden(d)))}function gformGetBasePrice(a,b){var c="_"+a+"_"+b,d=0,e=jQuery("#ginput_base_price"+c+", .gfield_donation"+c+' input[type="text"], .gfield_product'+c+" .ginput_amount");if(e.length>0)d=e.val(),gformIsHidden(e)&&(d=0);else{e=jQuery(".gfield_product"+c+" select, .gfield_product"+c+" input:checked, .gfield_donation"+c+" select, .gfield_donation"+c+" input:checked");var f=e.val();f&&(f=f.split("|"),d=f.length>1?f[1]:0),gformIsHidden(e)&&(d=0)}return d=new Currency(gf_global.gf_currency_config).toNumber(d),!1===d?0:d}function gformFormatMoney(a,b){return gf_global.gf_currency_config?new Currency(gf_global.gf_currency_config).toMoney(a,b):a}function gformFormatPricingField(a){if(gf_global.gf_currency_config){var b=new Currency(gf_global.gf_currency_config),c=b.toMoney(jQuery(a).val());jQuery(a).val(c)}}function gformToNumber(a){return new Currency(gf_global.gf_currency_config).toNumber(a)}function gformGetPriceDifference(a,b){var c=parseFloat(b)-parseFloat(a);return price=gformFormatMoney(c,!0),c>0&&(price="+"+price),price}function gformGetOptionLabel(a,b,c,d,e){a=jQuery(a);var f=gformGetPrice(b),g=a.attr("price"),h=a.html().replace(/<span(.*)<\/span>/i,"").replace(g,""),i=gformGetPriceDifference(c,f);i=0==gformToNumber(i)?"":" "+i,a.attr("price",i);var j="option"==a[0].tagName.toLowerCase()?" "+i:"<span class='ginput_price'>"+i+"</span>",k=h+j;return window.gform_format_option_label&&(k=gform_format_option_label(k,h,j,c,f,d,e)),k}function gformGetProductIds(a,b){for(var c=jQuery(b).hasClass(a)?jQuery(b).attr("class").split(" "):jQuery(b).parents("."+a).attr("class").split(" "),d=0;d<c.length;d++)if(c[d].substr(0,a.length)==a&&c[d]!=a)return{formId:c[d].split("_")[2],productFieldId:c[d].split("_")[3]};return{formId:0,fieldId:0}}function gformGetPrice(a){var b=a.split("|"),c=new Currency(gf_global.gf_currency_config);return b.length>1&&!1!==c.toNumber(b[1])?c.toNumber(b[1]):0}function gformRegisterPriceField(a){_gformPriceFields[a.formId]||(_gformPriceFields[a.formId]=new Array);for(var b=0;b<_gformPriceFields[a.formId].length;b++)if(_gformPriceFields[a.formId][b]==a.productFieldId)return;_gformPriceFields[a.formId].push(a.productFieldId)}function gformInitPriceFields(){jQuery(".gfield_price").each(function(){gformRegisterPriceField(gformGetProductIds("gfield_price",this)),jQuery(this).on("change",'input[type="text"], input[type="number"], select',function(){var a=gformGetProductIds("gfield_price",this);0==a.formId&&(a=gformGetProductIds("gfield_shipping",this)),jQuery(document).trigger("gform_price_change",[a,this]),gformCalculateTotalPrice(a.formId)}),jQuery(this).on("click",'input[type="radio"], input[type="checkbox"]',function(){var a=gformGetProductIds("gfield_price",this);0==a.formId&&(a=gformGetProductIds("gfield_shipping",this)),jQuery(document).trigger("gform_price_change",[a,this]),gformCalculateTotalPrice(a.formId)})});for(formId in _gformPriceFields)_gformPriceFields.hasOwnProperty(formId)&&gformCalculateTotalPrice(formId)}function gformShowPasswordStrength(a){var b=jQuery("#"+a).val(),c=jQuery("#"+a+"_2").val(),d=gformPasswordStrength(b,c),e=window.gf_text["password_"+d];jQuery("#"+a+"_strength").val(d),jQuery("#"+a+"_strength_indicator").removeClass("blank mismatch short good bad strong").addClass(d).html(e)}function gformPasswordStrength(a,b){var c,d,e=0;return a.length<=0?"blank":a!=b&&b.length>0?"mismatch":a.length<4?"short":(a.match(/[0-9]/)&&(e+=10),a.match(/[a-z]/)&&(e+=26),a.match(/[A-Z]/)&&(e+=26),a.match(/[^a-zA-Z0-9]/)&&(e+=31),c=Math.log(Math.pow(e,a.length)),d=c/Math.LN2,d<40?"bad":d<56?"good":"strong")}function gformAddListItem(a,b){var c=jQuery(a);if(!c.hasClass("gfield_icon_disabled")){var d=c.parents(".gfield_list_group"),e=d.clone(),f=d.parents(".gfield_list_container"),g=e.find(":input:last").attr("tabindex");e.find("input, select, textarea").attr("tabindex",g).not(":checkbox, :radio").val(""),e.find(":checkbox, :radio").prop("checked",!1),e=gform.applyFilters("gform_list_item_pre_add",e,d),d.after(e),gformToggleIcons(f,b),gformAdjustClasses(f),gform.doAction("gform_list_post_item_add",e,f)}}function gformDeleteListItem(a,b){var c=jQuery(a),d=c.parents(".gfield_list_group"),e=d.parents(".gfield_list_container");d.remove(),gformToggleIcons(e,b),gformAdjustClasses(e),gform.doAction("gform_list_post_item_delete",e)}function gformAdjustClasses(a){a.find(".gfield_list_group").each(function(a){var b=jQuery(this),c=(a+1)%2==0?"gfield_list_row_even":"gfield_list_row_odd";b.removeClass("gfield_list_row_odd gfield_list_row_even").addClass(c)})}function gformToggleIcons(a,b){var c=a.find(".gfield_list_group").length,d=a.find(".add_list_item");a.find(".delete_list_item").css("visibility",1==c?"hidden":"visible"),b>0&&c>=b?(d.data("title",a.find(".add_list_item").attr("title")),d.addClass("gfield_icon_disabled").attr("title","")):b>0&&(d.removeClass("gfield_icon_disabled"),d.data("title")&&d.attr("title",d.data("title")))}function gformMatchCard(a){var b=gformFindCardType(jQuery("#"+a).val()),c=jQuery("#"+a).parents(".gfield").find(".gform_card_icon_container");b?(jQuery(c).find(".gform_card_icon").removeClass("gform_card_icon_selected").addClass("gform_card_icon_inactive"),jQuery(c).find(".gform_card_icon_"+b).removeClass("gform_card_icon_inactive").addClass("gform_card_icon_selected")):jQuery(c).find(".gform_card_icon").removeClass("gform_card_icon_selected gform_card_icon_inactive")}function gformFindCardType(a){if(a.length<4)return!1;var b=window.gf_cc_rules,c=new Array;for(type in b)if(b.hasOwnProperty(type))for(i in b[type])if(b[type].hasOwnProperty(i)&&0===b[type][i].indexOf(a.substring(0,b[type][i].length))){c[c.length]=type;break}return 1==c.length&&c[0].toLowerCase()}function gformToggleCreditCard(){jQuery("#gform_payment_method_creditcard").is(":checked")?jQuery(".gform_card_fields_container").slideDown():jQuery(".gform_card_fields_container").slideUp()}function gformInitChosenFields(a,b){return jQuery(a).each(function(){var a=jQuery(this);if("rtl"==jQuery("html").attr("dir")&&a.addClass("chosen-rtl chzn-rtl"),a.is(":visible")&&0==a.siblings(".chosen-container").length){var c=gform.applyFilters("gform_chosen_options",{no_results_text:b},a);a.chosen(c)}})}function gformInitCurrencyFormatFields(a){jQuery(a).each(function(){jQuery(this).val(gformFormatMoney(jQuery(this).val()))}).change(function(a){jQuery(this).val(gformFormatMoney(jQuery(this).val()))})}function gformFormatNumber(a,b,c,d){if(void 0===c)if(window.gf_global){var e=new Currency(gf_global.gf_currency_config);c=e.currency.decimal_separator}else c=".";if(void 0===d)if(window.gf_global){var e=new Currency(gf_global.gf_currency_config);d=e.currency.thousand_separator}else d=",";var e=new Currency;return e.numberFormat(a,b,c,d,!1)}function gformToNumber(a){return new Currency(gf_global.gf_currency_config).toNumber(a)}function getMatchGroups(a,b){for(var c=new Array;b.test(a);){var d=c.length;c[d]=b.exec(a),a=a.replace(""+c[d][0],"")}return c}function gf_get_field_number_format(a,b,c){var d=rgars(window,"gf_global/number_formats/{0}/{1}".format(b,a)),e=!1;return""===d?e:e=void 0===c?!1!==d.price?d.price:d.value:d[c]}function renderRecaptcha(){jQuery(".ginput_recaptcha").each(function(){var a=jQuery(this),b={sitekey:a.data("sitekey"),theme:a.data("theme"),tabindex:a.data("tabindex")};a.is(":empty")&&(a.data("stoken")&&(b.stoken=a.data("stoken")),grecaptcha.render(this.id,b),b.tabindex&&a.find("iframe").attr("tabindex",b.tabindex),gform.doAction("gform_post_recaptcha_render",a))})}function gformValidateFileSize(a,b){var c;if(c=jQuery(a).closest("div").siblings(".validation_message").length>0?jQuery(a).closest("div").siblings(".validation_message"):jQuery(a).siblings(".validation_message"),window.FileReader&&window.File&&window.FileList&&window.Blob){var d=a.files[0];if(d&&d.size>b){c.text(d.name+" - "+gform_gravityforms.strings.file_exceeds_limit);var e=jQuery(a);e.replaceWith(e.val("").clone(!0))}else c.text("")}}function gformInitSpinner(a,b){jQuery("#gform_"+a).submit(function(){gformAddSpinner(a,b)})}function gformAddSpinner(a,b){if(void 0!==b&&b||(b=gform.applyFilters("gform_spinner_url",gf_global.spinnerUrl,a)),0==jQuery("#gform_ajax_spinner_"+a).length){gform.applyFilters("gform_spinner_target_elem",jQuery("#gform_submit_button_"+a+", #gform_wrapper_"+a+" .gform_next_button, #gform_send_resume_link_button_"+a),a).after('<img id="gform_ajax_spinner_'+a+'"  class="gform_ajax_spinner" src="'+b+'" alt="" />')}}function gf_raw_input_change(a,b){clearTimeout(__gf_keyup_timeout);var c=jQuery(b),d=c.attr("id"),e=gf_get_input_id_by_html_id(d),f=gf_get_form_id_by_html_id(d);if(e){var g=c.is(":checkbox")||c.is(":radio")||c.is("select"),h=!g||c.is("textarea");("keyup"!=a.type||h)&&("change"!=a.type||g||h)&&("keyup"==a.type?__gf_keyup_timeout=setTimeout(function(){gf_input_change(this,f,e)},300):gf_input_change(this,f,e))}}function gf_get_input_id_by_html_id(a){var b=gf_get_ids_by_html_id(a),c=b[2];return b[3]&&(c+="."+b[3]),c}function gf_get_form_id_by_html_id(a){return gf_get_ids_by_html_id(a)[1]}function gf_get_ids_by_html_id(a){return!!a&&a.split("_")}function gf_input_change(a,b,c){gform.doAction("gform_input_change",a,b,c)}function gformExtractFieldId(a){var b=parseInt(a.toString().split(".")[0]);return b||a}function gformExtractInputIndex(a){var b=parseInt(a.toString().split(".")[1]);return b||!1}function rgars(a,b){for(var c=b.split("/"),d=a,e=0;e<c.length;e++)d=rgar(d,c[e]);return d}function rgar(a,b){return void 0!==a[b]?a[b]:""}void 0===jQuery.fn.prop&&(jQuery.fn.prop=jQuery.fn.attr),jQuery(document).ready(function(){jQuery(document).bind("gform_post_render",gformBindFormatPricingFields)});var _gformPriceFields=new Array,_anyProductSelected,GFCalc=function(formId,formulaFields){this.patt=/{[^{]*?:(\d+(\.\d+)?)(:(.*?))?}/i,this.exprPatt=/^[0-9 -/*\(\)]+$/i,this.isCalculating={},this.init=function(a,b){var c=this;jQuery(document).bind("gform_post_conditional_logic",function(){for(var d=0;d<b.length;d++){var e=jQuery.extend({},b[d]);c.runCalc(e,a)}});for(var d=0;d<b.length;d++){var e=jQuery.extend({},b[d]);this.runCalc(e,a),this.bindCalcEvents(e,a)}},this.runCalc=function(formulaField,formId){var calcObj=this,field=jQuery("#field_"+formId+"_"+formulaField.field_id),formulaInput=jQuery("#input_"+formId+"_"+formulaField.field_id),previous_val=formulaInput.val(),formula=gform.applyFilters("gform_calculation_formula",formulaField.formula,formulaField,formId,calcObj),expr=calcObj.replaceFieldTags(formId,formula,formulaField).replace(/(\r\n|\n|\r)/gm,""),result="";if(calcObj.exprPatt.test(expr))try{result=eval(expr)}catch(a){}isFinite(result)||(result=0),window.gform_calculation_result&&(result=window.gform_calculation_result(result,formulaField,formId,calcObj),window.console&&console.log('"gform_calculation_result" function is deprecated since version 1.8! Use "gform_calculation_result" JS hook instead.')),result=gform.applyFilters("gform_calculation_result",result,formulaField,formId,calcObj);var formattedResult=gform.applyFilters("gform_calculation_format_result",!1,result,formulaField,formId,calcObj),numberFormat=gf_get_field_number_format(formulaField.field_id,formId);if(!1!==formattedResult)result=formattedResult;else if(field.hasClass("gfield_price")||"currency"==numberFormat)result=gformFormatMoney(result||0,!0);else{var decimalSeparator=".",thousandSeparator=",";"decimal_comma"==numberFormat&&(decimalSeparator=",",thousandSeparator="."),result=gformFormatNumber(result,gformIsNumber(formulaField.rounding)?formulaField.rounding:-1,decimalSeparator,thousandSeparator)}result!=previous_val&&(field.hasClass("gfield_price")?(formulaInput.text(result),jQuery("#ginput_base_price_"+formId+"_"+formulaField.field_id).val(result).trigger("change"),gformCalculateTotalPrice(formId)):formulaInput.val(result).trigger("change"))},this.bindCalcEvents=function(a,b){var c=this,d=a.field_id,e=getMatchGroups(a.formula,this.patt);c.isCalculating[d]=!1;for(var f in e)if(e.hasOwnProperty(f)){var g=e[f][1],h=parseInt(g),i=jQuery("#field_"+b+"_"+h).find('input[name="input_'+g+'"], select[name="input_'+g+'"]');"checkbox"==i.prop("type")||"radio"==i.prop("type")?jQuery(i).click(function(){c.bindCalcEvent(g,a,b,0)}):i.is("select")||"hidden"==i.prop("type")?jQuery(i).change(function(){c.bindCalcEvent(g,a,b,0)}):jQuery(i).keydown(function(){c.bindCalcEvent(g,a,b)}).change(function(){c.bindCalcEvent(g,a,b,0)}),gform.doAction("gform_post_calculation_events",e[f],a,b,c)}},this.bindCalcEvent=function(a,b,c,d){var e=this,f=b.field_id;d=void 0==d?345:d,e.isCalculating[f][a]&&clearTimeout(e.isCalculating[f][a]),e.isCalculating[f][a]=window.setTimeout(function(){e.runCalc(b,c)},d)},this.replaceFieldTags=function(a,b,c){var d=getMatchGroups(b,this.patt);for(i in d)if(d.hasOwnProperty(i)){var e=d[i][1],f=parseInt(e),g=(d[i][3],0),h=jQuery("#field_"+a+"_"+f).find('input[name="input_'+e+'"], select[name="input_'+e+'"]');(h.length>1||"checkbox"==h.prop("type"))&&(h=h.filter(":checked"));var j=!window.gf_check_field_rule||"show"==gf_check_field_rule(a,f,!0,"");if(h.length>0&&j){var k=h.val();k=k.split("|"),g=k.length>1?k[1]:h.val()}var l=gf_get_field_number_format(f,a);l||(l=gf_get_field_number_format(c.field_id,a));var m=gformGetDecimalSeparator(l);g=gform.applyFilters("gform_merge_tag_value_pre_calculation",g,d[i],j,c,a),g=gformCleanNumber(g,"","",m),g||(g=0),b=b.replace(d[i][0],g)}return b},this.init(formId,formulaFields)},gform={hooks:{action:{},filter:{}},addAction:function(a,b,c,d){gform.addHook("action",a,b,c,d)},addFilter:function(a,b,c,d){gform.addHook("filter",a,b,c,d)},doAction:function(a){gform.doHook("action",a,arguments)},applyFilters:function(a){return gform.doHook("filter",a,arguments)},removeAction:function(a,b){gform.removeHook("action",a,b)},removeFilter:function(a,b,c){gform.removeHook("filter",a,b,c)},addHook:function(a,b,c,d,e){void 0==gform.hooks[a][b]&&(gform.hooks[a][b]=[]);var f=gform.hooks[a][b];void 0==e&&(e=b+"_"+f.length),void 0==d&&(d=10),gform.hooks[a][b].push({tag:e,callable:c,priority:d})},doHook:function(a,b,c){if(c=Array.prototype.slice.call(c,1),void 0!=gform.hooks[a][b]){var d,e=gform.hooks[a][b];e.sort(function(a,b){return a.priority-b.priority});for(var f=0;f<e.length;f++)d=e[f].callable,"function"!=typeof d&&(d=window[d]),"action"==a?d.apply(null,c):c[0]=d.apply(null,c)}if("filter"==a)return c[0]},removeHook:function(a,b,c,d){if(void 0!=gform.hooks[a][b])for(var e=gform.hooks[a][b],f=e.length-1;f>=0;f--)void 0!=d&&d!=e[f].tag||void 0!=c&&c!=e[f].priority||e.splice(f,1)}};!function(a,b){function c(c){function h(a,c){b("#"+a).prepend("<li>"+e(c)+"</li>")}function i(){var a,c="#gform_uploaded_files_"+r,d=b(c);return a=d.val(),a=void 0===a||""===a?{}:b.parseJSON(a)}function j(a){var b=i(),c=n(a);return void 0===b[c]&&(b[c]=[]),b[c]}function k(a){return j(a).length}function l(a,b){var c=j(a);c.unshift(b),m(a,c)}function m(a,c){var d=i(),e=b("#gform_uploaded_files_"+r);d[n(a)]=c,e.val(b.toJSON(d))}function n(a){return"input_"+a}function o(a){a.preventDefault()}var p=b(c).data("settings"),q=new plupload.Uploader(p);r=q.settings.multipart_params.form_id,a.uploaders[p.container]=q;var r,s;q.bind("Init",function(c,d){c.features.dragdrop||b(".gform_drop_instructions").hide();var e=c.settings.multipart_params.field_id,f=parseInt(c.settings.gf_vars.max_files),g=k(e);f>0&&g>=f&&a.toggleDisabled(c.settings,!0)}),a.toggleDisabled=function(a,c){b("string"==typeof a.browse_button?"#"+a.browse_button:a.browse_button).prop("disabled",c)},q.init(),q.bind("FilesAdded",function(c,g){var i,j=parseInt(c.settings.gf_vars.max_files),l=c.settings.multipart_params.field_id,m=k(l),n=c.settings.gf_vars.disallowed_extensions;if(j>0&&m>=j)return void b.each(g,function(a,b){c.removeFile(b)});b.each(g,function(a,d){if(i=d.name.split(".").pop(),b.inArray(i,n)>-1)return h(c.settings.gf_vars.message_id,d.name+" - "+f.illegal_extension),void c.removeFile(d);if(d.status==plupload.FAILED||j>0&&m>=j)return void c.removeFile(d);var g=void 0!==d.size?plupload.formatSize(d.size):f.in_progress,k='<div id="'+d.id+'" class="ginput_preview">'+e(d.name)+" ("+g+') <b></b> <a href="javascript:void(0)" title="'+f.cancel_upload+"\" onclick='$this=jQuery(this); var uploader = gfMultiFileUploader.uploaders."+c.settings.container+';uploader.stop();uploader.removeFile(uploader.getFile("'+d.id+'"));$this.after("'+f.cancelled+"\"); uploader.start();$this.remove();' onkeypress='$this=jQuery(this); var uploader = gfMultiFileUploader.uploaders."+c.settings.container+';uploader.stop();uploader.removeFile(uploader.getFile("'+d.id+'"));$this.after("'+f.cancelled+"\"); uploader.start();$this.remove();'>"+f.cancel+"</a></div>";b("#"+c.settings.filelist).prepend(k),m++}),c.refresh();var o="form#gform_"+r,p="input:hidden[name='gform_unique_id']",q=o+" "+p,t=b(q);0==t.length&&(t=b(p)),s=t.val(),""===s&&(s=d(),t.val(s)),j>0&&m>=j&&(a.toggleDisabled(c.settings,!0),h(c.settings.gf_vars.message_id,f.max_reached)),c.settings.multipart_params.gform_unique_id=s,c.start()}),q.bind("UploadProgress",function(a,c){var d=c.percent+"%";b("#"+c.id+" b").html(d)}),q.bind("Error",function(a,c){if(c.code===plupload.FILE_EXTENSION_ERROR){var d=void 0!==a.settings.filters.mime_types?a.settings.filters.mime_types[0].extensions:a.settings.filters[0].extensions;h(a.settings.gf_vars.message_id,c.file.name+" - "+f.invalid_file_extension+" "+d)}else if(c.code===plupload.FILE_SIZE_ERROR)h(a.settings.gf_vars.message_id,c.file.name+" - "+f.file_exceeds_limit);else{var e="Error: "+c.code+", Message: "+c.message+(c.file?", File: "+c.file.name:"");h(a.settings.gf_vars.message_id,e)}b("#"+c.file.id).html(""),a.refresh()}),q.bind("FileUploaded",function(a,c,d){var i=b.secureEvalJSON(d.response);if("error"==i.status)return h(a.settings.gf_vars.message_id,c.name+" - "+i.error.message),void b("#"+c.id).html("");var j="<strong>"+e(c.name)+"</strong>",k=a.settings.multipart_params.form_id,m=a.settings.multipart_params.field_id;j="<img class='gform_delete' src='"+g+"/delete.png' onclick='gformDeleteUploadedFile("+k+","+m+", this);' onkeypress='gformDeleteUploadedFile("+k+","+m+", this);' alt='"+f.delete_file+"' title='"+f.delete_file+"' /> "+j,j=gform.applyFilters("gform_file_upload_markup",j,c,a,f,g),b("#"+c.id).html(j);var n=a.settings.multipart_params.field_id;100==c.percent&&(i.status&&"ok"==i.status?l(n,i.data):h(a.settings.gf_vars.message_id,f.unknown_error+": "+c.name))}),b("#"+p.drop_element).on({dragenter:o,dragover:o})}function d(){return"xxxxxxxx".replace(/[xy]/g,function(a){var b=16*Math.random()|0;return("x"==a?b:3&b|8).toString(16)})}function e(a){return b("<div/>").text(a).html()}a.uploaders={};var f="undefined"!=typeof gform_gravityforms?gform_gravityforms.strings:{},g="undefined"!=typeof gform_gravityforms?gform_gravityforms.vars.images_url:"";b(document).bind("gform_post_render",function(d,e){b("form#gform_"+e+" .gform_fileupload_multifile").each(function(){c(this)});var g=b("form#gform_"+e);g.length>0&&g.submit(function(){var c=!1;if(b.each(a.uploaders,function(a,b){if(b.total.queued>0)return c=!0,!1}),c)return alert(f.currently_uploading),window["gf_submitting_"+e]=!1,b("#gform_ajax_spinner_"+e).remove(),!1})}),b(document).bind("gform_post_conditional_logic",function(c,d,e,f){f||b.each(a.uploaders,function(a,b){b.refresh()})}),b(document).ready(function(){"undefined"!=typeof adminpage&&"toplevel_page_gf_edit_forms"===adminpage||"undefined"==typeof plupload?b(".gform_button_select_files").prop("disabled",!0):"undefined"!=typeof adminpage&&adminpage.indexOf("_page_gf_entries")>-1&&b(".gform_fileupload_multifile").each(function(){c(this)})}),a.setup=function(a){c(a)}}(window.gfMultiFileUploader=window.gfMultiFileUploader||{},jQuery);var __gf_keyup_timeout;jQuery(document).on("change keyup",".gfield_trigger_change input, .gfield_trigger_change select, .gfield_trigger_change textarea",function(a){gf_raw_input_change(a,this)}),window.rgars,window.rgar,String.prototype.format=function(){var a=arguments;return this.replace(/{(\d+)}/g,function(b,c){return void 0!==a[c]?a[c]:b})};