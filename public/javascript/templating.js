// public/js/templating.js

function evaluateTemplateExpressions() {
    const elements = document.querySelectorAll('*');

    elements.forEach((el) => {
        // Check for href attributes with expressions
        if (el.hasAttribute('href')) {
            const hrefValue = el.getAttribute('href');
            // Replace {expression} with the evaluated result
            const evaluatedHref = hrefValue.replace(/{{([^}]+)}}/g, (match, code) => {
                try {
                    return new Function('return ' + code)(); // Evaluate the code
                } catch (e) {
                    console.error('Error evaluating expression:', e);
                    return ''; // In case of an error, return empty
                }
            });
            el.setAttribute('href', evaluatedHref); // Set the evaluated value
        }

        // Check for other attributes or inner text with expressions
        if (el.innerHTML.match(/{{([^}]+)}}/)) {
            el.innerHTML = el.innerHTML.replace(/{{([^}]+)}}/g, (match, code) => {
                try {
                    return new Function('return ' + code)(); // Evaluate the code
                } catch (e) {
                    console.error('Error evaluating expression:', e);
                    return ''; // In case of an error, return empty
                }
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', evaluateTemplateExpressions);
