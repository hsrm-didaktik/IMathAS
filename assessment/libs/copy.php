<?php
//copy.php
// By Ingo Dahn (dahn@dahn-research.eu)
// This library provides a button to copy a string to the clipboard

global $allowedmacros;
array_push($allowedmacros,"copyButton" );

function copyButton($arg="",$label="Copy to clipboard") {
    $js_cp="
    <script>
    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement('textarea');
        textArea.value = text;
        
        // Avoid scrolling to bottom
        textArea.style.top = '0';
        textArea.style.left = '0';
        textArea.style.position = 'fixed';
      
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
      
        try {
          var successful = document.execCommand('copy');
          var msg = successful ? 'successful' : 'unsuccessful';
          console.log('Fallback: Copying text command was ' + msg);
        } catch (err) {
          console.error('Fallback: Oops, unable to copy', err);
        }
      
        document.body.removeChild(textArea);
      }
      function copyTextToClipboard(text) {
        if (!navigator.clipboard) {
          fallbackCopyTextToClipboard(text);
          return;
        }
        navigator.clipboard.writeText(text).then(function() {
          console.log('Async: Copying to clipboard was successful!');
        }, function(err) {
          console.error('Async: Could not copy text: ', err);
        });
      }
      var copyBtn = document.querySelector('.js-copy-btn');
      copyBtn.addEventListener('click', function(event) {
        copyTextToClipboard('$arg');
      });
    </script>";
    return "
    <div style='display:inline-block; vertical-align:top;'>
      <button class='js-copy-btn'>$label</button>
    </div>".$js_cp;
}

?>