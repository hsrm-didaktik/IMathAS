<?php
//copy.php
// By Ingo Dahn (dahn@dahn-research.eu)
// This library provides a button to copy a string to the clipboard

global $allowedmacros;
array_push($allowedmacros,"copyButton" );

function copyButton($arg="",$label="Copy to clipboard",$successMessage="Copied to clipboard",$failMessage="Copy failed!") {
  $js_cp="
  <script>
    function reportSuccess (success) {
      let responseDiv=document.getElementById('js_cp_response');
      let response=(success)?'$successMessage':'$failMessage';
      alert(response);
    }
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
        reportSuccess(successful);
      } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
      }
      document.body.removeChild(textArea);
    }
    async function copyTextToClipboard(text) {
        console.log('copytextToClipboard called');
        if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
        return;
      }
      try {
        await navigator.clipboard.writeText(text).then(function() {
        reportSuccess(true);
        console.log('Async: Copying to clipboard was successful!');
      })} catch (err) {
        reportSuccess(false);
        console.error('Async: Could not copy text: ', err);
      };
    }
    </script>
  ";
  $html = "<button type=\"button\" onclick=\"copyTextToClipboard('$arg')\">$label</button>";
  return $js_cp.$html;
}

?>