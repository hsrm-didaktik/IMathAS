<?php
//Chat extension

global $allowedmacros;
array_push($allowedmacros,"asciimath2tex", "copyButton", "essayText");

require(__DIR__."/../../filter/math/ASCIIMath2TeX.php");

function asciimath2tex($AMstring) {
  $AMT = new AMtoTeX;
	$tex = $AMT->convert($AMstring); //convert ASCIIMath string to TeX
    return "$ $tex $";
}


function copyButton($arg="",$label="Copy to clipboard",$successMessage="Copied to clipboard",$failMessage="Copy failed!",$formatPrompt="Der folgende Text kann Formeln in ASCIIMath-Format zwischen Backticks `...` enthalten. Die Antwort sollte Formeln mit LaTeX darstellen.\\n") {
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
    async function copyTextToClipboard(textEncoded) {
        var text = '$formatPrompt'+atob(textEncoded);        
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
  $html = "<button type=\"button\" onclick=\"copyTextToClipboard('" . base64_encode($arg) . "')\">$label</button>";
  return $js_cp.$html;
}

function ascii2texText($ascii) {
  $pos=stripos($ascii,'`');
  if ($pos === false ) {
    return $ascii;
  }
  $parts=explode("`",$ascii);
  $result="";
  for ($i=0; $i<count($parts); $i++) {
    if ($i % 2 == 1) {
      $result.=asciimath2tex($parts[$i]);
    } else {
      $result.=$parts[$i];
    }
  }
  return $result;
}

function essayText($html) {
  $dom = new DOMDocument();
  $html1 = '<html><body><div id="myDiv">'.$html.'</div></body></html>';
  $dom->loadHTML($html1);
  $divTag = $dom->getElementById('myDiv');
  $extractedText = $divTag->textContent;
  return ascii2texText($extractedText);
}

?>