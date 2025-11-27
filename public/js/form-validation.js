(function(){
  function applyEmailValidation(el){
    if (!el || el.__emailValidationApplied) return;
    el.__emailValidationApplied = true;
    el.addEventListener('invalid', function(){
      try {
        this.setCustomValidity(this.validity.valueMissing ? 'Email wajib diisi.' : 'Masukkan alamat email yang valid.');
      } catch (e) { /* ignore */ }
    });
    el.addEventListener('input', function(){
      try { this.setCustomValidity(''); } catch (e) { /* ignore */ }
    });
  }

  function init(){
    document.querySelectorAll('input[type="email"]').forEach(applyEmailValidation);

    // Observe dynamically added inputs
    const mo = new MutationObserver(function(mutations){
      for (const m of mutations){
        for (const node of m.addedNodes){
          if (node.nodeType !== 1) continue; // ELEMENT_NODE
          if (node.matches && node.matches('input[type="email"]')) applyEmailValidation(node);
          if (node.querySelectorAll){
            node.querySelectorAll('input[type="email"]').forEach(applyEmailValidation);
          }
        }
      }
    });
    mo.observe(document.body, { childList: true, subtree: true });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
