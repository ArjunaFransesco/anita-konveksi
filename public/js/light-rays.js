/**
 * LightRays - Pure Canvas 2D Light Ray Effect
 * No external dependencies. Draws white light beams from top-center.
 */
(function () {

  class LightRays {
    constructor(container, options = {}) {
      if (!container) return;
      this.container = container;

      // Config
      this.raysOrigin    = options.raysOrigin      || 'top-center';
      this.raysColor     = options.raysColor        || '#ffffff';
      this.raysSpeed     = options.raysSpeed        !== undefined ? options.raysSpeed     : 1.0;
      this.lightSpread   = options.lightSpread      !== undefined ? options.lightSpread   : 0.4;
      this.rayLength     = options.rayLength        !== undefined ? options.rayLength     : 3.0;
      this.followMouse   = options.followMouse      !== undefined ? options.followMouse   : true;
      this.mouseInfluence= options.mouseInfluence   !== undefined ? options.mouseInfluence: 0.1;
      this.numRays       = options.numRays          !== undefined ? options.numRays       : 10;
      this.maxAlpha      = options.maxAlpha         !== undefined ? options.maxAlpha      : 0.4;

      // Internal state
      this.canvas        = null;
      this.ctx           = null;
      this.animId        = null;
      this.width         = 0;
      this.height        = 0;
      this.time          = 0;
      this.mouse         = { x: 0.5, y: 0.5 };
      this.smoothMouse   = { x: 0.5, y: 0.5 };
      this.isVisible     = false;
      this.observer      = null;

      // Stable per-ray random seeds
      this.rays = [];
      for (let i = 0; i < this.numRays; i++) {
        this.rays.push({
          baseAngle : (Math.random() - 0.5) * Math.PI * this.lightSpread,
          speed     : 0.15 + Math.random() * 0.25,
          phase     : Math.random() * Math.PI * 2,
          width     : 0.012 + Math.random() * 0.022,
          alpha     : 0.015 + Math.random() * 0.03,
        });
      }

      this._handleMouse  = this._handleMouse.bind(this);
      this._onResize     = this._onResize.bind(this);
      this._loop         = this._loop.bind(this);

      this._setup();
    }

    /* ── bootstrap ─────────────────────────────────────── */
    _setup() {
      this.canvas = document.createElement('canvas');
      this.canvas.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;display:block;';
      this.container.appendChild(this.canvas);
      this.ctx = this.canvas.getContext('2d');

      this._resize();
      window.addEventListener('resize', this._onResize);
      if (this.followMouse) window.addEventListener('mousemove', this._handleMouse);

      // IntersectionObserver — only animate when visible
      if ('IntersectionObserver' in window) {
        this.observer = new IntersectionObserver((entries) => {
          this.isVisible = entries[0].isIntersecting;
          if (this.isVisible) this._startLoop();
          else this._stopLoop();
        }, { threshold: 0.05 });
        this.observer.observe(this.container);
      } else {
        this.isVisible = true;
        this._startLoop();
      }
    }

    /* ── sizing ─────────────────────────────────────────── */
    _resize() {
      const dpr = window.devicePixelRatio || 1;
      this.width  = this.container.clientWidth;
      this.height = this.container.clientHeight;
      this.canvas.width  = this.width  * dpr;
      this.canvas.height = this.height * dpr;
      this.ctx.scale(dpr, dpr);
    }
    _onResize() { this._resize(); }

    /* ── mouse ──────────────────────────────────────────── */
    _handleMouse(e) {
      const rect = this.container.getBoundingClientRect();
      this.mouse.x = (e.clientX - rect.left) / rect.width;
      this.mouse.y = (e.clientY - rect.top)  / rect.height;
    }

    /* ── origin point ───────────────────────────────────── */
    _getOrigin() {
      const w = this.width, h = this.height;
      const outside = 0.12;
      switch (this.raysOrigin) {
        case 'top-left'    : return { x: w * 0.1,  y: -h * outside };
        case 'top-right'   : return { x: w * 0.9,  y: -h * outside };
        case 'bottom-center': return { x: w * 0.5, y: h * (1 + outside) };
        case 'left'        : return { x: -w * outside,      y: h * 0.5 };
        case 'right'       : return { x:  w * (1 + outside), y: h * 0.5 };
        default            : return { x: w * 0.5,  y: -h * outside };   // top-center
      }
    }

    /* ── base direction angle ───────────────────────────── */
    _getBaseAngle() {
      switch (this.raysOrigin) {
        case 'top-left'    : return  Math.PI * 0.35;
        case 'top-right'   : return  Math.PI * 0.65;
        case 'bottom-center': return -Math.PI * 0.5;
        case 'left'        : return  0;
        case 'right'       : return  Math.PI;
        default            : return  Math.PI * 0.5;   // top-center → down
      }
    }

    /* ── parse color to rgb string ──────────────────────── */
    _colorRgb() {
      const hex = this.raysColor.replace('#', '');
      if (hex.length === 3) {
        return [
          parseInt(hex[0]+hex[0], 16),
          parseInt(hex[1]+hex[1], 16),
          parseInt(hex[2]+hex[2], 16),
        ];
      }
      return [
        parseInt(hex.slice(0,2), 16),
        parseInt(hex.slice(2,4), 16),
        parseInt(hex.slice(4,6), 16),
      ];
    }

    /* ── draw one frame ─────────────────────────────────── */
    _draw() {
      const ctx = this.ctx;
      const W = this.width, H = this.height;
      ctx.clearRect(0, 0, W, H);

      // Smooth mouse
      const sm = 0.93;
      this.smoothMouse.x = this.smoothMouse.x * sm + this.mouse.x * (1 - sm);
      this.smoothMouse.y = this.smoothMouse.y * sm + this.mouse.y * (1 - sm);

      const origin = this._getOrigin();
      const baseAngle = this._getBaseAngle();

      // Mouse offset on the base angle
      const mouseOffsetX = (this.smoothMouse.x - 0.5) * this.mouseInfluence * Math.PI;
      const mouseOffsetY = (this.smoothMouse.y - 0.5) * this.mouseInfluence * Math.PI * 0.5;
      const dirAngle = baseAngle + mouseOffsetX + mouseOffsetY;

      const [r, g, b] = this._colorRgb();
      const rayDist   = Math.max(W, H) * this.rayLength;

      this.rays.forEach((ray) => {
        const t = this.time * this.raysSpeed * ray.speed + ray.phase;
        // Animate angle slightly back and forth
        const swingAngle = Math.sin(t) * 0.08 * this.lightSpread;
        const angle = dirAngle + ray.baseAngle + swingAngle;

        // Tip of the ray
        const tipX = origin.x + Math.cos(angle) * rayDist;
        const tipY = origin.y + Math.sin(angle) * rayDist;

        // Half-width vector (perpendicular to ray direction)
        const perp = angle + Math.PI / 2;
        const halfW = rayDist * ray.width;
        const lx = origin.x + Math.cos(perp) * halfW;
        const ly = origin.y + Math.sin(perp) * halfW;
        const rx = origin.x - Math.cos(perp) * halfW;
        const ry = origin.y - Math.sin(perp) * halfW;

        // Animated alpha (gentle pulse)
        const alpha = ray.alpha * (0.7 + 0.3 * Math.sin(t * 1.3));

        const grad = ctx.createLinearGradient(origin.x, origin.y, tipX, tipY);
        grad.addColorStop(0,   `rgba(${r},${g},${b},${Math.min(alpha * 1.5, this.maxAlpha * 2)})`);
        grad.addColorStop(0.2, `rgba(${r},${g},${b},${Math.min(alpha, this.maxAlpha)})`);
        grad.addColorStop(1,   `rgba(${r},${g},${b},0)`);

        ctx.beginPath();
        ctx.moveTo(origin.x, origin.y);
        ctx.lineTo(lx, ly);
        ctx.lineTo(tipX, tipY);
        ctx.lineTo(rx, ry);
        ctx.closePath();

        ctx.fillStyle = grad;
        ctx.globalCompositeOperation = 'lighter';
        ctx.fill();
      });

      // Central bright glow at origin
      const glowR = W * 0.35;
      const glowGrad = ctx.createRadialGradient(origin.x, origin.y, 0, origin.x, origin.y, glowR);
      glowGrad.addColorStop(0,   `rgba(${r},${g},${b},0.05)`);
      glowGrad.addColorStop(0.3, `rgba(${r},${g},${b},0.02)`);
      glowGrad.addColorStop(1,   `rgba(${r},${g},${b},0)`);
      ctx.beginPath();
      ctx.arc(origin.x, origin.y, glowR, 0, Math.PI * 2);
      ctx.fillStyle = glowGrad;
      ctx.globalCompositeOperation = 'lighter';
      ctx.fill();

      ctx.globalCompositeOperation = 'source-over';
    }

    /* ── loop ───────────────────────────────────────────── */
    _loop(ts) {
      this.time = (ts || 0) * 0.001;
      this._draw();
      this.animId = requestAnimationFrame(this._loop);
    }
    _startLoop() {
      if (!this.animId) {
        this.animId = requestAnimationFrame(this._loop);
      }
    }
    _stopLoop() {
      if (this.animId) {
        cancelAnimationFrame(this.animId);
        this.animId = null;
      }
    }

    /* ── cleanup ────────────────────────────────────────── */
    destroy() {
      this._stopLoop();
      window.removeEventListener('resize', this._onResize);
      window.removeEventListener('mousemove', this._handleMouse);
      if (this.observer) this.observer.disconnect();
      if (this.canvas && this.canvas.parentNode) this.canvas.parentNode.removeChild(this.canvas);
    }
  }

  window.LightRays = LightRays;

})();
