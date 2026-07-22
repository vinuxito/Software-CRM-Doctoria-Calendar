<!-- Interactive Anatomical Body Map SVG Canvas -->
<div class="body-map-container" style="display: flex; gap: 20px; align-items: flex-start; justify-content: center; background: #fafafa; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin: 15px 0;">
    <!-- Vista Anterior (Front) -->
    <div style="flex: 1; text-align: center; position: relative;">
        <span style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Vista Anterior (Frente)</span>
        <div id="body-map-anterior-wrapper" class="body-map-wrapper" data-vista="anterior" style="position: relative; margin-top: 8px; cursor: crosshair; display: inline-block;">
            <svg width="220" height="380" viewBox="0 0 200 360" style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));">
                <!-- Body Silhouette Anterior -->
                <g fill="#CBD5E1" stroke="#94A3B8" stroke-width="2" stroke-linejoin="round">
                    <!-- Head -->
                    <ellipse cx="100" cy="35" rx="22" ry="26" />
                    <!-- Neck -->
                    <path d="M90 60 L110 60 L112 72 L88 72 Z" />
                    <!-- Shoulders & Torso -->
                    <path d="M88 72 L60 85 L45 130 L55 135 L68 95 L72 170 L128 170 L132 95 L145 135 L155 130 L140 85 L112 72 Z" />
                    <!-- Arms (Left/Right) -->
                    <path d="M45 130 L35 180 L44 185 L55 135 Z" />
                    <path d="M155 130 L165 180 L156 185 L145 135 Z" />
                    <!-- Pelvis & Legs -->
                    <path d="M72 170 L70 250 L68 330 L85 330 L88 250 L100 185 L112 250 L115 330 L132 330 L130 250 L128 170 Z" fill="#CBD5E1" />
                    <!-- Feet -->
                    <path d="M68 330 L58 345 L85 345 L85 330 Z" />
                    <path d="M115 330 L115 345 L142 345 L132 330 Z" />
                </g>
            </svg>
            <!-- Dynamic Pin Overlay Layer -->
            <div id="pins-layer-anterior" class="pins-overlay-layer" style="position: absolute; top:0; left:0; width:100%; height:100%; pointer-events: none;"></div>
        </div>
    </div>

    <!-- Vista Posterior (Back) -->
    <div style="flex: 1; text-align: center; position: relative;">
        <span style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Vista Posterior (Espalda)</span>
        <div id="body-map-posterior-wrapper" class="body-map-wrapper" data-vista="posterior" style="position: relative; margin-top: 8px; cursor: crosshair; display: inline-block;">
            <svg width="220" height="380" viewBox="0 0 200 360" style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));">
                <!-- Body Silhouette Posterior -->
                <g fill="#94A3B8" stroke="#64748B" stroke-width="2" stroke-linejoin="round">
                    <!-- Head Back -->
                    <ellipse cx="100" cy="35" rx="22" ry="26" />
                    <!-- Neck -->
                    <path d="M90 60 L110 60 L112 72 L88 72 Z" />
                    <!-- Back Torso & Scapula -->
                    <path d="M88 72 L60 85 L45 130 L55 135 L68 95 L72 170 L128 170 L132 95 L145 135 L155 130 L140 85 L112 72 Z" />
                    <!-- Arms Back -->
                    <path d="M45 130 L35 180 L44 185 L55 135 Z" />
                    <path d="M155 130 L165 180 L156 185 L145 135 Z" />
                    <!-- Lumbar & Gluteal/Legs Back -->
                    <path d="M72 170 L70 250 L68 330 L85 330 L88 250 L100 185 L112 250 L115 330 L132 330 L130 250 L128 170 Z" />
                    <!-- Feet Back -->
                    <path d="M68 330 L65 348 L85 348 L85 330 Z" />
                    <path d="M115 330 L115 348 L135 348 L132 330 Z" />
                </g>
            </svg>
            <!-- Dynamic Pin Overlay Layer -->
            <div id="pins-layer-posterior" class="pins-overlay-layer" style="position: absolute; top:0; left:0; width:100%; height:100%; pointer-events: none;"></div>
        </div>
    </div>
</div>
