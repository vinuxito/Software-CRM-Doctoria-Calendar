// Doctoria CRM — Patients Clinical Record Wizard Section JS Module
'use strict';

document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('patient-file-modal');
    if (!modal) return;

    var closeBtn = document.getElementById('patient-file-modal-close');
    var viewBtns = document.querySelectorAll('.btn-view-patient-file');
    
    // State management
    var activePatientId = 0;
    var currentStep = 1;
    var currentExpedienteId = 0;

    var antecedenteItems = [
        {key: "diabetes", label: "Diabetes", grupo: "patologico"},
        {key: "alergia", label: "Alergia", grupo: "patologico"},
        {key: "hta", label: "HTA", grupo: "patologico"},
        {key: "cancer", label: "Cáncer", grupo: "patologico"},
        {key: "marcapasos", label: "Marcapasos", grupo: "patologico"},
        {key: "reumaticas", label: "Enf. Reumáticas", grupo: "patologico"},
        {key: "encames", label: "Encames", grupo: "patologico"},
        {key: "accidentes", label: "Accidentes", grupo: "patologico"},
        {key: "cardiopatias", label: "Cardiopatías", grupo: "patologico"},
        {key: "cirugias", label: "Cirugías", grupo: "patologico"},
        {key: "fracturas", label: "Fracturas", grupo: "patologico"},
        {key: "tabaquismo", label: "Tabaquismo", grupo: "no_patologico"},
        {key: "alcoholismo", label: "Alcoholismo", grupo: "no_patologico"},
        {key: "drogas", label: "Drogas", grupo: "no_patologico"},
        {key: "actividad_fisica", label: "Actividad Física", grupo: "no_patologico"},
        {key: "embarazo", label: "Embarazo", grupo: "no_patologico"},
        {key: "hijos", label: "Hijos", grupo: "no_patologico", placeholder: "¿Cuántos?"}
    ];

    var tinettiCriteria = [
        {key: "inicio_marcha", label: "Inicio de la marcha", options: [
            {val: 0, text: "Duda, vacila o múltiples intentos para comenzar"},
            {val: 1, text: "No vacilante"}
        ]},
        {key: "paso_pd_longitud", label: "Paso pie derecho - Longitud", options: [
            {val: 0, text: "El pie derecho no sobrepasa al izquierdo con el paso"},
            {val: 1, text: "El pie derecho sobrepasa al izquierdo con el paso"}
        ]},
        {key: "paso_pd_altura", label: "Paso pie derecho - Altura", options: [
            {val: 0, text: "El pie derecho no se levanta completamente del suelo"},
            {val: 1, text: "El pie derecho se levanta completamente"}
        ]},
        {key: "paso_pi_longitud", label: "Paso pie izquierdo - Longitud", options: [
            {val: 0, text: "El pie izquierdo no sobrepasa al derecho con el paso"},
            {val: 1, text: "El pie izquierdo sobrepasa al derecho con el paso"}
        ]},
        {key: "paso_pi_altura", label: "Paso pie izquierdo - Altura", options: [
            {val: 0, text: "El pie izquierdo no se levanta completamente del suelo"},
            {val: 1, text: "El pie izquierdo se levanta completamente"}
        ]},
        {key: "simetria_paso", label: "Simetría del paso", options: [
            {val: 0, text: "La longitud del paso con el pie derecho e izquierdo es diferente"},
            {val: 1, text: "Los pasos son iguales en longitud"}
        ]},
        {key: "continuidad_pasos", label: "Continuidad de los pasos", options: [
            {val: 0, text: "Para o hay discontinuidad entre los pasos"},
            {val: 1, text: "Los pasos son continuos"}
        ]},
        {key: "trayectoria", label: "Trayectoria (Estimada en baldosas)", options: [
            {val: 0, text: "Marcada desviación"},
            {val: 1, text: "Desviación moderada, media o utiliza ayudas"},
            {val: 2, text: "Derecho sin utilizar ayudas"}
        ]},
        {key: "tronco", label: "Tronco", options: [
            {val: 0, text: "Marcado balanceo o utiliza ayudas"},
            {val: 1, text: "No balanceo pero hay flexión de espalda/brazos extensión"},
            {val: 2, text: "No balanceo ni flexión, ni utiliza ayudas"}
        ]},
        {key: "postura_marcha", label: "Postura en la marcha", options: [
            {val: 0, text: "Talones separados"},
            {val: 1, text: "Talones casi se tocan al caminar"}
        ]}
    ];

    var problemaRows = [
        {key: "dolor", label: "Dolor"},
        {key: "edema", label: "Edema"},
        {key: "limitacion_articular", label: "Limitación articular"},
        {key: "contractura", label: "Contractura"},
        {key: "supuracion", label: "Supuración"},
        {key: "infeccion", label: "Infección"},
        {key: "inmovilizacion", label: "Inmovilización"},
        {key: "ayuda_marcha", label: "Ayuda para marcha"}
    ];

    // Initialize layout components dynamically
    function renderAntecedentesList() {
        var containerA = document.getElementById('antecedentes-grupo-a');
        var containerB = document.getElementById('antecedentes-grupo-b');
        if (!containerA || !containerB) return;
        containerA.innerHTML = '';
        containerB.innerHTML = '';

        antecedenteItems.forEach(function (item) {
            var div = document.createElement('div');
            div.className = 'antecedente-item-row';
            div.style.padding = '8px 0';
            div.style.borderBottom = '1px dashed #eee';
            
            div.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <span style="font-weight: 500; font-size: 12px; color: #444;">${item.label}</span>
                    <div class="segmented-control" data-key="${item.key}">
                        <button type="button" class="segmented-btn" data-val="si">Sí</button>
                        <button type="button" class="segmented-btn" data-val="no">No</button>
                        <button type="button" class="segmented-btn" data-val="null">N/A</button>
                    </div>
                </div>
                <div class="spec-input-container" id="spec-container-${item.key}">
                    <input type="text" id="spec-${item.key}" placeholder="${item.placeholder || 'Especificaciones...'}" style="width: 100%; font-size: 12px; padding: 5px;">
                </div>
            `;

            // Segmented controls event listeners
            var btns = div.querySelectorAll('.segmented-btn');
            btns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var val = btn.dataset.val;
                    setSegmentedValue(item.key, val);
                    runAutosave();
                });
            });

            if (item.grupo === 'patologico') {
                containerA.appendChild(div);
            } else {
                containerB.appendChild(div);
            }
        });
    }

    function setSegmentedValue(key, val) {
        var container = document.querySelector(`.segmented-control[data-key="${key}"]`);
        if (!container) return;
        var btns = container.querySelectorAll('.segmented-btn');
        btns.forEach(function (btn) {
            btn.className = 'segmented-btn';
            if (btn.dataset.val === val) {
                btn.className = `segmented-btn active-${val}`;
            }
        });

        var specContainer = document.getElementById(`spec-container-${key}`);
        if (specContainer) {
            if (val === 'si') {
                specContainer.classList.add('active');
            } else {
                specContainer.classList.remove('active');
                var specInput = document.getElementById(`spec-${key}`);
                if (specInput) specInput.value = '';
            }
        }
        checkClinicalWarnings();
    }

    function getSegmentedValue(key) {
        var container = document.querySelector(`.segmented-control[data-key="${key}"]`);
        if (!container) return 'null';
        var active = container.querySelector('.active-si, .active-no, .active-unset');
        return active ? active.dataset.val : 'null';
    }

    function checkClinicalWarnings() {
        var marcapasos = getSegmentedValue('marcapasos') === 'si';
        var embarazo = getSegmentedValue('embarazo') === 'si';

        var badge = document.getElementById('wizard-warning-badge');
        var echo = document.getElementById('step-4-warning-echo');

        if (marcapasos || embarazo) {
            if (badge) badge.style.display = 'flex';
            if (echo) echo.style.display = 'flex';
        } else {
            if (badge) badge.style.display = 'none';
            if (echo) echo.style.display = 'none';
        }
    }

    function renderProblemasGrid() {
        var tbody = document.querySelector('#problemas-grid-table tbody');
        if (!tbody) return;
        tbody.innerHTML = '';
        problemaRows.forEach(function (row) {
            var tr = document.createElement('tr');
            tr.style.borderBottom = '1px solid #eee';
            tr.innerHTML = `
                <td style="padding: 6px; font-weight: 500; font-size: 12px; color: #444;">${row.label}</td>
                <td style="padding: 6px;">
                    <select id="prob-sev-${row.key}" style="width: 100%; font-size: 11px; padding: 4px;">
                        <option value="null">No especificado</option>
                        <option value="leve">Leve</option>
                        <option value="moderado">Moderado</option>
                        <option value="severo">Severo</option>
                        <option value="na">No aplica</option>
                    </select>
                </td>
                <td style="padding: 6px;">
                    <input type="text" id="prob-nota-${row.key}" placeholder="Notas..." style="width: 100%; font-size: 11px; padding: 4px;">
                </td>
            `;
            tr.querySelector('select').addEventListener('change', runAutosave);
            tr.querySelector('input').addEventListener('blur', runAutosave);
            tbody.appendChild(tr);
        });
    }

    function renderTinettiContainer() {
        var container = document.getElementById('tinetti-scoring-container');
        if (!container) return;
        container.innerHTML = '';
        tinettiCriteria.forEach(function (crit) {
            var div = document.createElement('div');
            div.style.marginBottom = '14px';
            div.innerHTML = `
                <span style="font-family: var(--font-heading); font-weight: bold; font-size: 12px; color: var(--slate-text); display: block; margin-bottom: 6px;">${crit.label}</span>
                <div class="tinetti-segmented-row">
                    ${crit.options.map(function (opt) {
                        return `
                            <label class="tinetti-option-card">
                                <input type="radio" name="tinetti-${crit.key}" value="${opt.val}" style="display: none;">
                                <div class="tinetti-card-content">
                                    <span class="tinetti-card-score">${opt.val} pts</span>
                                    <span class="tinetti-card-desc">${opt.text}</span>
                                </div>
                            </label>
                        `;
                    }).join('')}
                </div>
            `;

            div.querySelectorAll('input[type="radio"]').forEach(function (radio) {
                radio.addEventListener('change', function () {
                    calculateGaitTotals();
                    runAutosave();
                });
            });
            container.appendChild(div);
        });
    }

    // EVA Pain scale faces and colors mapping
    var evaSlider = document.getElementById('eva-slider-input');
    var evaLabel = document.getElementById('eva-label');
    var evaEmoji = document.getElementById('eva-emoji');

    var evaStates = {
        0: { emoji: '😊', label: 'Sin dolor', color: '#6c757d' },
        1: { emoji: '🙂', label: 'Dolor muy leve', color: '#41464b' },
        2: { emoji: '💙', label: 'Dolor leve', color: '#0d6efd' },
        3: { emoji: '😐', label: 'Dolor leve a moderado', color: '#0dcaf0' },
        4: { emoji: '💛', label: 'Dolor moderado', color: '#ffc107' },
        5: { emoji: '😕', label: 'Dolor moderado a severo', color: '#fd7e14' },
        6: { emoji: '💚', label: 'Dolor severo', color: '#198754' },
        7: { emoji: '😰', label: 'Dolor bastante severo', color: '#20c997' },
        8: { emoji: '🖤', label: 'Dolor muy severo', color: '#212529' },
        9: { emoji: '😩', label: 'Dolor casi insoportable', color: '#dc3545' },
        10: { emoji: '😭', label: 'Máximo dolor', color: '#a83232' }
    };

    function updateEvaScaleDisplay(val, isTouched) {
        if (!evaEmoji || !evaLabel) return;
        if (!isTouched) {
            evaEmoji.textContent = '⚪';
            evaLabel.textContent = 'No tocado';
            evaLabel.style.color = '#888';
            return;
        }
        var state = evaStates[val] || evaStates[0];
        evaEmoji.textContent = state.emoji;
        evaLabel.textContent = `${state.label} (${val}/10)`;
        evaLabel.style.color = state.color;
    }

    var evaTouched = false;
    if (evaSlider) {
        evaSlider.addEventListener('input', function () {
            evaTouched = true;
            updateEvaScaleDisplay(parseInt(evaSlider.value), true);
            runAutosave();
        });
    }

    // Age Auto-compute
    var dobInput = document.getElementById('patient-fecha-nacimiento');
    var edadInput = document.getElementById('patient-edad');

    if (dobInput && edadInput) {
        dobInput.addEventListener('change', function () {
            var birthdateStr = dobInput.value;
            if (birthdateStr) {
                var age = computeAge(birthdateStr);
                edadInput.value = age;
                edadInput.readOnly = true;
                edadInput.style.background = '#f1f3f5';
            } else {
                edadInput.value = '';
                edadInput.readOnly = false;
                edadInput.style.background = '#ffffff';
            }
            runAutosave();
        });
    }

    function computeAge(birthdateStr) {
        if (!birthdateStr) return '';
        var today = new Date();
        var birthDate = new Date(birthdateStr);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    function syncChipsFromSelect(selectId) {
        var select = document.getElementById(selectId);
        if (!select) return;
        var val = select.value;
        var container = document.querySelector(`.option-chips-container[data-target="${selectId}"]`);
        if (container) {
            var chips = container.querySelectorAll('.option-chip');
            chips.forEach(function (chip) {
                if (chip.dataset.value === val) {
                    chip.classList.add('active');
                } else {
                    chip.classList.remove('active');
                }
            });
        }
    }

    function setupOptionChips() {
        var containers = document.querySelectorAll('.option-chips-container');
        containers.forEach(function (container) {
            var targetSelectId = container.dataset.target;
            var select = document.getElementById(targetSelectId);
            if (select) {
                select.style.display = 'none'; // Hide select
                var chips = container.querySelectorAll('.option-chip');
                chips.forEach(function (chip) {
                    chip.addEventListener('click', function () {
                        select.value = chip.dataset.value;
                        var event = new Event('change');
                        select.dispatchEvent(event);
                        syncChipsFromSelect(targetSelectId);
                    });
                });
            }
        });
    }

    function updateIMCGauge() {
        var estaturaInput = document.getElementById('exploracion-estatura');
        var pesoInput = document.getElementById('exploracion-peso');
        var gaugeBlock = document.getElementById('imc-gauge-block');
        var valueBadge = document.getElementById('imc-value-badge');
        var needle = document.getElementById('imc-gauge-needle');

        if (!estaturaInput || !pesoInput || !gaugeBlock || !valueBadge || !needle) return;

        var estatura = parseFloat(estaturaInput.value);
        var peso = parseFloat(pesoInput.value);

        if (estatura > 0 && peso > 0) {
            var h = estatura / 100;
            var imc = peso / (h * h);
            gaugeBlock.style.display = 'block';

            var category = '';
            var bg = '';
            var fg = '';

            if (imc < 18.5) {
                category = 'Bajo Peso';
                bg = '#EBF8FF';
                fg = '#2B6CB0';
            } else if (imc >= 18.5 && imc < 25) {
                category = 'Saludable';
                bg = '#C6F6D5';
                fg = '#22543D';
            } else if (imc >= 25 && imc < 30) {
                category = 'Sobrepeso';
                bg = '#FEFCBF';
                fg = '#744210';
            } else {
                category = 'Obesidad';
                bg = '#FED7D7';
                fg = '#742A2A';
            }

            valueBadge.textContent = `${imc.toFixed(1)} - ${category}`;
            valueBadge.style.backgroundColor = bg;
            valueBadge.style.color = fg;

            // Map IMC range 15 to 35 onto 0% to 100%
            var pct = ((imc - 15) / (35 - 15)) * 100;
            if (pct < 0) pct = 0;
            if (pct > 100) pct = 100;
            needle.style.left = pct + '%';
        } else {
            gaugeBlock.style.display = 'none';
        }
    }

    function setupTAMask() {
        var taInput = document.getElementById('exploracion-ta');
        if (!taInput) return;
        taInput.addEventListener('input', function () {
            var val = taInput.value;
            var cleaned = val.replace(/[^\d\/]/g, '');
            if (cleaned.length === 4 && !cleaned.includes('/')) {
                cleaned = cleaned.slice(0, 3) + '/' + cleaned.slice(3);
            }
            if (cleaned !== val) {
                taInput.value = cleaned;
            }
        });
    }

    var scrollFade = document.getElementById('wizard-scroll-fade');
    function updateScrollIndicator(el) {
        if (!scrollFade || !el) return;
        var hasScroll = el.scrollHeight > el.clientHeight;
        var isNearBottom = el.scrollHeight - el.scrollTop <= el.clientHeight + 8;
        if (hasScroll && !isNearBottom) {
            scrollFade.classList.add('visible');
        } else {
            scrollFade.classList.remove('visible');
        }
    }

    // Surgical scar master toggle
    var cicatrizMasterSi = document.querySelector('#cicatriz-master-control button[data-val="1"]');
    var cicatrizMasterNo = document.querySelector('#cicatriz-master-control button[data-val="0"]');
    var cicatrizContainer = document.getElementById('cicatriz-details-container');

    function setCicatrizMaster(val) {
        if (!cicatrizMasterSi || !cicatrizMasterNo || !cicatrizContainer) return;
        cicatrizMasterSi.className = 'segmented-btn';
        cicatrizMasterNo.className = 'segmented-btn';

        if (val === 1) {
            cicatrizMasterSi.className = 'segmented-btn active-si';
            cicatrizContainer.style.display = 'block';
        } else {
            cicatrizMasterNo.className = 'segmented-btn active-no';
            cicatrizContainer.style.display = 'none';
            // Clear inputs
            var sitio = document.getElementById('cicatriz-sitio');
            if (sitio) sitio.value = '';
            var q = document.getElementById('cicatriz-queloide'); if (q) q.checked = false;
            var r = document.getElementById('cicatriz-retractil'); if (r) r.checked = false;
            var a = document.getElementById('cicatriz-abierta'); if (a) a.checked = false;
            var c = document.getElementById('cicatriz-con-adherencia'); if (c) c.checked = false;
            var h = document.getElementById('cicatriz-hipertrofica'); if (h) h.checked = false;
        }
    }

    if (cicatrizMasterSi && cicatrizMasterNo) {
        cicatrizMasterSi.addEventListener('click', function () { setCicatrizMaster(1); runAutosave(); });
        cicatrizMasterNo.addEventListener('click', function () { setCicatrizMaster(0); runAutosave(); });
    }

    // Repeatable plan session rows
    var planContainer = document.getElementById('treatment-sessions-container');
    var addPlanBtn = document.getElementById('btn-add-treatment-row');

    function createTreatmentRow(fechaVal, indicacionesVal) {
        if (!planContainer) return;
        var row = document.createElement('div');
        row.className = 'repeatable-row';
        row.innerHTML = `
            <button type="button" class="repeatable-row-remove">×</button>
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 10px; align-items: flex-start;">
                <div>
                    <label style="font-size: 11px; font-weight: bold; margin-bottom: 2px;">Fecha</label>
                    <input type="date" class="session-fecha" value="${fechaVal || ''}" style="padding: 4px; font-size: 11px; width: 100%;">
                </div>
                <div>
                    <label style="font-size: 11px; font-weight: bold; margin-bottom: 2px;">Indicaciones (frecuencia y duración)</label>
                    <textarea class="session-indicaciones" rows="1" style="padding: 4px; font-size: 11px; width: 100%; border: 1px solid #ccc; border-radius: 4px; resize: vertical;">${indicacionesVal || ''}</textarea>
                </div>
            </div>
        `;

        row.querySelector('.repeatable-row-remove').addEventListener('click', function () {
            row.remove();
            runAutosave();
        });

        row.querySelector('.session-fecha').addEventListener('change', runAutosave);
        row.querySelector('.session-indicaciones').addEventListener('blur', runAutosave);

        planContainer.appendChild(row);
    }

    if (addPlanBtn) {
        addPlanBtn.addEventListener('click', function () {
            createTreatmentRow('', '');
        });
    }

    // Gait score checkboxes toggle showing specific inputs
    var gaitOtrosCheck = document.getElementById('gait-otros');
    var gaitOtrosSpecContainer = document.getElementById('gait-otros-spec-container');
    if (gaitOtrosCheck && gaitOtrosSpecContainer) {
        gaitOtrosCheck.addEventListener('change', function () {
            gaitOtrosSpecContainer.style.display = gaitOtrosCheck.checked ? 'block' : 'none';
            if (!gaitOtrosCheck.checked) {
                var spec = document.getElementById('gait-otros-spec');
                if (spec) spec.value = '';
            }
            runAutosave();
        });
    }

    // Tinetti & totals calculator
    var balanceInput = document.getElementById('score-balance-manual');
    if (balanceInput) {
        balanceInput.addEventListener('input', function () {
            calculateGaitTotals();
            runAutosave();
        });
    }

    function calculateGaitTotals() {
        var totalMarcha = 0;
        tinettiCriteria.forEach(function (crit) {
            var radios = document.getElementsByName(`tinetti-${crit.key}`);
            radios.forEach(function (radio) {
                if (radio.checked) {
                    totalMarcha += parseInt(radio.value);
                }
            });
        });

        if (!balanceInput) return;
        var totalBalance = parseInt(balanceInput.value) || 0;
        if (totalBalance < 0) totalBalance = 0;
        if (totalBalance > 16) totalBalance = 16;
        balanceInput.value = totalBalance;

        var grandTotal = totalMarcha + totalBalance;

        var mVal = document.getElementById('score-marcha-val'); if (mVal) mVal.textContent = totalMarcha;
        var gVal = document.getElementById('score-general-val'); if (gVal) gVal.textContent = grandTotal;

        var riskBadge = document.getElementById('tinetti-risk-badge');
        if (riskBadge) {
            if (grandTotal < 19) {
                riskBadge.className = 'status-chip status-rejected';
                riskBadge.textContent = 'Alto Riesgo de Caídas (<19)';
            } else if (grandTotal >= 19 && grandTotal <= 24) {
                riskBadge.className = 'status-chip status-pending';
                riskBadge.textContent = 'Riesgo Moderado (19-24)';
            } else {
                riskBadge.className = 'status-chip status-approved';
                riskBadge.textContent = 'Bajo Riesgo (25+)';
            }
        }

        // Upgraded SVG Ring updates
        var svgRing = document.getElementById('tinetti-svg-ring');
        var svgText = document.getElementById('tinetti-svg-text');
        var riskText = document.getElementById('tinetti-risk-badge-text');

        if (svgRing && svgText && riskText) {
            svgText.textContent = `${grandTotal}/28`;
            var pct = (grandTotal / 28) * 100;
            svgRing.style.strokeDasharray = `${pct}, 100`;

            if (grandTotal < 19) {
                svgRing.style.stroke = '#D66F7C'; 
                riskText.textContent = 'Alto Riesgo de Caída';
                riskText.style.color = '#D66F7C';
            } else if (grandTotal >= 19 && grandTotal <= 24) {
                svgRing.style.stroke = '#E5A87B'; 
                riskText.textContent = 'Riesgo Moderado';
                riskText.style.color = '#E5A87B';
            } else {
                svgRing.style.stroke = '#7FB8A6'; 
                riskText.textContent = 'Bajo Riesgo';
                riskText.style.color = '#7FB8A6';
            }
        }
    }

    // Modal view initialization trigger
    viewBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var patientId = parseInt(btn.dataset.id);
            activePatientId = patientId;
            openWizard(patientId);
        });
    });

    function populateForm(data) {
        // Populate Step 1 (Datos del Paciente)
        var nameField = document.getElementById('patient-name'); if (nameField) nameField.value = data.patient.name || '';
        var ocField = document.getElementById('patient-ocupacion'); if (ocField) ocField.value = data.patient.ocupacion || '';
        var dobField = document.getElementById('patient-fecha-nacimiento'); if (dobField) dobField.value = data.patient.fecha_nacimiento || '';
        var edadField = document.getElementById('patient-edad'); if (edadField) edadField.value = data.patient.fecha_nacimiento ? computeAge(data.patient.fecha_nacimiento) : '';
        var sexField = document.getElementById('patient-sexo'); if (sexField) { sexField.value = data.patient.sexo || ''; syncChipsFromSelect('patient-sexo'); }
        var civField = document.getElementById('patient-estado-civil'); if (civField) { civField.value = data.patient.estado_civil || ''; syncChipsFromSelect('patient-estado-civil'); }
        var domField = document.getElementById('patient-domicilio'); if (domField) domField.value = data.patient.domicilio || '';
        var telField = document.getElementById('patient-tel'); if (telField) telField.value = data.patient.tel || '';
        var celField = document.getElementById('patient-cel'); if (celField) celField.value = data.patient.cel || '';
        var famField = document.getElementById('patient-familiar-responsable'); if (famField) famField.value = data.patient.familiar_responsable || '';
        var ftelField = document.getElementById('patient-familiar-tel-cel'); if (ftelField) ftelField.value = data.patient.familiar_cel || data.patient.familiar_tel || '';

        // Populate Step 2 (Antecedentes)
        if (data.antecedentes && data.antecedentes.length > 0) {
            data.antecedentes.forEach(function (ant) {
                setSegmentedValue(ant.item_key, ant.valor);
                var specInput = document.getElementById(`spec-${ant.item_key}`);
                if (specInput) specInput.value = ant.especificacion || '';
            });
        } else {
            antecedenteItems.forEach(function(item) {
                setSegmentedValue(item.key, 'null');
            });
        }

        // Populate Step 3
        if (data.exploracion) {
            var est = document.getElementById('exploracion-estatura'); if (est) est.value = data.exploracion.estatura_cm || '';
            var pes = document.getElementById('exploracion-peso'); if (pes) pes.value = data.exploracion.peso_kg || '';
            var ta = document.getElementById('exploracion-ta'); if (ta) ta.value = data.exploracion.ta || '';
            var fc = document.getElementById('exploracion-fc'); if (fc) fc.value = data.exploracion.fc || '';
            var fr = document.getElementById('exploracion-fr'); if (fr) fr.value = data.exploracion.fr || '';
            var arc = document.getElementById('exploracion-arcos'); if (arc) arc.value = data.exploracion.arcos_movimiento || '';
            var fue = document.getElementById('exploracion-fuerza'); if (fue) fue.value = data.exploracion.fuerza_muscular || '';
            var ref = document.getElementById('exploracion-reflejos'); if (ref) ref.value = data.exploracion.reflejos || '';
            var sen = document.getElementById('exploracion-sensibilidad'); if (sen) sen.value = data.exploracion.sensibilidad || '';
            var len = document.getElementById('exploracion-lenguaje-orientacion'); if (len) len.value = data.exploracion.lenguaje_orientacion || '';
            var otr = document.getElementById('exploracion-otros'); if (otr) otr.value = data.exploracion.otros || '';
            updateIMCGauge();
        }

        if (data.cicatriz) {
            setCicatrizMaster(parseInt(data.cicatriz.presenta));
            var csit = document.getElementById('cicatriz-sitio'); if (csit) csit.value = data.cicatriz.sitio || '';
            var cque = document.getElementById('cicatriz-queloide'); if (cque) cque.checked = data.cicatriz.queloide === 'si';
            var cret = document.getElementById('cicatriz-retractil'); if (cret) cret.checked = data.cicatriz.retractil === 'si';
            var cabi = document.getElementById('cicatriz-abierta'); if (cabi) cabi.checked = data.cicatriz.abierta === 'si';
            var ccad = document.getElementById('cicatriz-con-adherencia'); if (ccad) ccad.checked = data.cicatriz.con_adherencia === 'si';
            var chip = document.getElementById('cicatriz-hipertrofica'); if (chip) chip.checked = data.cicatriz.hipertrofica === 'si';
        }

        if (data.padecimiento) {
            var pmot = document.getElementById('padecimiento-motivo'); if (pmot) pmot.value = data.padecimiento.motivo_consulta || '';
            var pini = document.getElementById('padecimiento-inicio'); if (pini) pini.value = data.padecimiento.inicio || '';
            var pevo = document.getElementById('padecimiento-evolucion'); if (pevo) pevo.value = data.padecimiento.evolucion || '';
            var pest = document.getElementById('padecimiento-estudios'); if (pest) pest.value = data.padecimiento.estudios || '';
            var ptra = document.getElementById('padecimiento-tratamientos'); if (ptra) ptra.value = data.padecimiento.tratamientos_previos || '';
        }

        var eva_val = data.expediente ? data.expediente.eva_dolor : null;
        if (data.eva_dolor !== undefined) eva_val = data.eva_dolor;
        
        if (eva_val !== null && eva_val !== undefined && evaSlider) {
            evaTouched = true;
            evaSlider.value = eva_val;
            updateEvaScaleDisplay(eva_val, true);
        } else {
            evaTouched = false;
            if (evaSlider) evaSlider.value = 0;
            updateEvaScaleDisplay(0, false);
        }

        if (data.problemas && data.problemas.length > 0) {
            data.problemas.forEach(function (prob) {
                var sevSelect = document.getElementById(`prob-sev-${prob.item_key}`);
                var noteInput = document.getElementById(`prob-nota-${prob.item_key}`);
                if (sevSelect) sevSelect.value = prob.severidad || 'null';
                if (noteInput) noteInput.value = prob.nota || '';
            });
        }

        // Populate Step 4
        if (planContainer) planContainer.innerHTML = '';
        if (data.plan_sesiones && data.plan_sesiones.length > 0) {
            data.plan_sesiones.forEach(function (ses) {
                createTreatmentRow(ses.fecha, ses.indicaciones);
            });
        } else {
            createTreatmentRow('', '');
        }
        
        var notes_val = data.expediente ? data.expediente.notas_generales : '';
        if (data.notas_generales !== undefined) notes_val = data.notas_generales;
        var ngen = document.getElementById('expediente-notas-generales');
        if (ngen) ngen.value = notes_val || '';

        // Populate Step 5
        if (data.marcha) {
            var glib = document.getElementById('gait-libre'); if (glib) glib.checked = parseInt(data.marcha.libre) === 1;
            var gcla = document.getElementById('gait-claudicante'); if (gcla) gcla.checked = parseInt(data.marcha.claudicante) === 1;
            var gcay = document.getElementById('gait-con-ayuda'); if (gcay) gcay.checked = parseInt(data.marcha.con_ayuda) === 1;
            var gesp = document.getElementById('gait-espasticas'); if (gesp) gesp.checked = parseInt(data.marcha.espasticas) === 1;
            var gata = document.getElementById('gait-ataxica'); if (gata) gata.checked = parseInt(data.marcha.ataxica) === 1;
            var gotr = document.getElementById('gait-otros'); if (gotr) gotr.checked = parseInt(data.marcha.otros) === 1;
            if (gaitOtrosSpecContainer) gaitOtrosSpecContainer.style.display = data.marcha.otros ? 'block' : 'none';
            var gots = document.getElementById('gait-otros-spec'); if (gots) gots.value = data.marcha.otros_spec || '';
            var gobs = document.getElementById('gait-observaciones'); if (gobs) gobs.value = data.marcha.observaciones || '';

            tinettiCriteria.forEach(function (crit) {
                var val = data.marcha[crit.key];
                if (val !== null && val !== undefined && val !== '') {
                    var radio = document.querySelector(`input[name="tinetti-${crit.key}"][value="${val}"]`);
                    if (radio) radio.checked = true;
                }
            });

            if (balanceInput) balanceInput.value = data.marcha.total_balance_manual !== null ? data.marcha.total_balance_manual : 0;
            calculateGaitTotals();
        }

        checkClinicalWarnings();
    }

    function openWizard(patientId) {
        currentStep = 1;
        showStep(1);
        
        // Render empty lists
        renderAntecedentesList();
        renderProblemasGrid();
        renderTinettiContainer();
        if (planContainer) planContainer.innerHTML = '';
        
        updateAutosaveUI('saving', 'Cargando expediente...');

        // Check localStorage first (GC-5)
        var localDraftStr = localStorage.getItem(`expediente_draft_${patientId}`);
        var useLocal = false;
        
        if (localDraftStr) {
            try {
                var localDraft = JSON.parse(localDraftStr);
                if (localDraft && localDraft.data && localDraft.data.patient.name) {
                    if (confirm('Se encontró un borrador local más reciente de este expediente. ¿Desea restaurarlo?')) {
                        populateForm(localDraft.data);
                        useLocal = true;
                        updateAutosaveUI('saved', 'Borrador local restaurado');
                        modal.classList.add('active');
                    }
                }
            } catch (e) {
                console.error(e);
            }
        }

        if (useLocal) return;

        var url = (window.URLROOT || '') + `/dashboard/loadExpediente/${patientId}`;
        fetch(url)
            .then(function (res) { return res.json(); })
            .then(function (data) {
                currentExpedienteId = data.expediente.id;
                populateForm(data);
                updateAutosaveUI('saved', 'Expediente cargado');
                modal.classList.add('active');
            })
            .catch(function (err) {
                console.error(err);
                updateAutosaveUI('error', 'Error al cargar');
            });
    }

    // Step Switching Logic
    var indicators = document.querySelectorAll('.wizard-step-indicator');
    
    function showStep(stepNum) {
        currentStep = stepNum;
        document.querySelectorAll('.wizard-step-content').forEach(function (content) {
            content.classList.remove('active');
        });
        var stepContent = document.getElementById(`step-content-${stepNum}`);
        if (stepContent) stepContent.classList.add('active');

        indicators.forEach(function (ind) {
            ind.classList.remove('active');
            var indStep = parseInt(ind.dataset.step);
            if (indStep === stepNum) {
                ind.classList.add('active');
            } else if (indStep < stepNum) {
                ind.classList.add('visited');
            }
        });

        // Toggle buttons
        var prevBtn = document.getElementById('wizard-btn-prev');
        var nextBtn = document.getElementById('wizard-btn-next');
        var saveBtn = document.getElementById('wizard-btn-save');
        var label = document.getElementById('wizard-step-label');

        if (prevBtn) prevBtn.style.display = stepNum === 1 ? 'none' : 'block';
        if (nextBtn && saveBtn) {
            if (stepNum === 5) {
                nextBtn.style.display = 'none';
                saveBtn.style.display = 'block';
            } else {
                nextBtn.style.display = 'block';
                saveBtn.style.display = 'none';
            }
        }
        if (label) label.textContent = `Paso ${stepNum} de 5`;

        var activeContent = document.getElementById(`step-content-${stepNum}`);
        if (activeContent) {
            updateScrollIndicator(activeContent);
        }
    }

    var btnPrev = document.getElementById('wizard-btn-prev');
    if (btnPrev) {
        btnPrev.addEventListener('click', function () {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        });
    }

    var btnNext = document.getElementById('wizard-btn-next');
    if (btnNext) {
        btnNext.addEventListener('click', function () {
            if (currentStep < 5) {
                showStep(currentStep + 1);
            }
        });
    }

    indicators.forEach(function (ind) {
        ind.addEventListener('click', function () {
            var stepNum = parseInt(ind.dataset.step);
            showStep(stepNum);
        });
    });

    // Collect values from the DOM form and compile payload
    function collectFormPayload() {
        var nameVal = document.getElementById('patient-name') ? document.getElementById('patient-name').value : '';
        var ocVal = document.getElementById('patient-ocupacion') ? document.getElementById('patient-ocupacion').value : '';
        var dobVal = document.getElementById('patient-fecha-nacimiento') ? document.getElementById('patient-fecha-nacimiento').value : '';
        var sexVal = document.getElementById('patient-sexo') ? document.getElementById('patient-sexo').value : '';
        var civVal = document.getElementById('patient-estado-civil') ? document.getElementById('patient-estado-civil').value : '';
        var domVal = document.getElementById('patient-domicilio') ? document.getElementById('patient-domicilio').value : '';
        var celVal = document.getElementById('patient-cel') ? document.getElementById('patient-cel').value : '';
        var telVal = document.getElementById('patient-tel') ? document.getElementById('patient-tel').value : '';
        var famVal = document.getElementById('patient-familiar-responsable') ? document.getElementById('patient-familiar-responsable').value : '';
        var ftelVal = document.getElementById('patient-familiar-tel-cel') ? document.getElementById('patient-familiar-tel-cel').value : '';

        var estVal = document.getElementById('exploracion-estatura') ? document.getElementById('exploracion-estatura').value : '';
        var pesVal = document.getElementById('exploracion-peso') ? document.getElementById('exploracion-peso').value : '';
        var taVal = document.getElementById('exploracion-ta') ? document.getElementById('exploracion-ta').value : '';
        var fcVal = document.getElementById('exploracion-fc') ? document.getElementById('exploracion-fc').value : '';
        var frVal = document.getElementById('exploracion-fr') ? document.getElementById('exploracion-fr').value : '';
        var arcVal = document.getElementById('exploracion-arcos') ? document.getElementById('exploracion-arcos').value : '';
        var fueVal = document.getElementById('exploracion-fuerza') ? document.getElementById('exploracion-fuerza').value : '';
        var refVal = document.getElementById('exploracion-reflejos') ? document.getElementById('exploracion-reflejos').value : '';
        var senVal = document.getElementById('exploracion-sensibilidad') ? document.getElementById('exploracion-sensibilidad').value : '';
        var lenVal = document.getElementById('exploracion-lenguaje-orientacion') ? document.getElementById('exploracion-lenguaje-orientacion').value : '';
        var otrVal = document.getElementById('exploracion-otros') ? document.getElementById('exploracion-otros').value : '';

        var csitVal = document.getElementById('cicatriz-sitio') ? document.getElementById('cicatriz-sitio').value : '';
        var cqueVal = document.getElementById('cicatriz-queloide') ? (document.getElementById('cicatriz-queloide').checked ? 'si' : 'no') : 'no';
        var cretVal = document.getElementById('cicatriz-retractil') ? (document.getElementById('cicatriz-retractil').checked ? 'si' : 'no') : 'no';
        var cabiVal = document.getElementById('cicatriz-abierta') ? (document.getElementById('cicatriz-abierta').checked ? 'si' : 'no') : 'no';
        var ccadVal = document.getElementById('cicatriz-con-adherencia') ? (document.getElementById('cicatriz-con-adherencia').checked ? 'si' : 'no') : 'no';
        var chipVal = document.getElementById('cicatriz-hipertrofica') ? (document.getElementById('cicatriz-hipertrofica').checked ? 'si' : 'no') : 'no';

        var pmotVal = document.getElementById('padecimiento-motivo') ? document.getElementById('padecimiento-motivo').value : '';
        var piniVal = document.getElementById('padecimiento-inicio') ? document.getElementById('padecimiento-inicio').value : '';
        var pevoVal = document.getElementById('padecimiento-evolucion') ? document.getElementById('padecimiento-evolucion').value : '';
        var pestVal = document.getElementById('padecimiento-estudios') ? document.getElementById('padecimiento-estudios').value : '';
        var ptraVal = document.getElementById('padecimiento-tratamientos') ? document.getElementById('padecimiento-tratamientos').value : '';

        var ngenVal = document.getElementById('expediente-notas-generales') ? document.getElementById('expediente-notas-generales').value : '';

        var glibVal = document.getElementById('gait-libre') ? (document.getElementById('gait-libre').checked ? 1 : 0) : 0;
        var gclaVal = document.getElementById('gait-claudicante') ? (document.getElementById('gait-claudicante').checked ? 1 : 0) : 0;
        var gcayVal = document.getElementById('gait-con-ayuda') ? (document.getElementById('gait-con-ayuda').checked ? 1 : 0) : 0;
        var gespVal = document.getElementById('gait-espasticas') ? (document.getElementById('gait-espasticas').checked ? 1 : 0) : 0;
        var gataVal = document.getElementById('gait-ataxica') ? (document.getElementById('gait-ataxica').checked ? 1 : 0) : 0;
        var gotrVal = document.getElementById('gait-otros') ? (document.getElementById('gait-otros').checked ? 1 : 0) : 0;
        var gotsVal = document.getElementById('gait-otros-spec') ? document.getElementById('gait-otros-spec').value : '';
        var gobsVal = document.getElementById('gait-observaciones') ? document.getElementById('gait-observaciones').value : '';
        var sbalVal = balanceInput ? balanceInput.value : 0;

        var payload = {
            patient: {
                name: nameVal,
                ocupacion: ocVal,
                fecha_nacimiento: dobVal,
                sexo: sexVal,
                estado_civil: civVal,
                domicilio: domVal,
                phone: celVal || telVal || '',
                tel: telVal,
                cel: celVal,
                familiar_responsable: famVal,
                familiar_tel: ftelVal,
                familiar_cel: ftelVal
            },
            expediente: {
                eva_dolor: evaTouched ? parseInt(evaSlider.value) : null,
                notas_generales: ngenVal,
                notas_plan: ''
            },
            antecedentes: antecedenteItems.map(function (item) {
                var val = getSegmentedValue(item.key);
                var specEl = document.getElementById(`spec-${item.key}`);
                var spec = specEl ? specEl.value : '';
                return {
                    grupo: item.grupo,
                    item_key: item.key,
                    valor: val,
                    especificacion: spec
                };
            }),
            exploracion: {
                estatura_cm: estVal,
                peso_kg: pesVal,
                ta: taVal,
                fc: fcVal,
                fr: frVal,
                arcos_movimiento: arcVal,
                fuerza_muscular: fueVal,
                reflejos: refVal,
                sensibilidad: senVal,
                lenguaje_orientacion: lenVal,
                otros: otrVal
            },
            cicatriz: {
                presenta: document.querySelector('#cicatriz-master-control .active-si') ? 1 : 0,
                sitio: csitVal,
                queloide: cqueVal,
                retractil: cretVal,
                abierta: cabiVal,
                con_adherencia: ccadVal,
                hipertrofica: chipVal
            },
            padecimiento: {
                motivo_consulta: pmotVal,
                inicio: piniVal,
                evolucion: pevoVal,
                estudios: pestVal,
                tratamientos_previos: ptraVal
            },
            problemas: problemaRows.map(function (row) {
                var sevEl = document.getElementById(`prob-sev-${row.key}`);
                var noteEl = document.getElementById(`prob-nota-${row.key}`);
                return {
                    item_key: row.key,
                    severidad: sevEl ? sevEl.value : 'null',
                    nota: noteEl ? noteEl.value : ''
                };
            }),
            plan_sesiones: Array.from(document.querySelectorAll('#treatment-sessions-container .repeatable-row')).map(function (row) {
                return {
                    fecha: row.querySelector('.session-fecha').value,
                    indicaciones: row.querySelector('.session-indicaciones').value
                };
            }),
            marcha: {
                libre: glibVal,
                claudicante: gclaVal,
                con_ayuda: gcayVal,
                espasticas: gespVal,
                ataxica: gataVal,
                otros: gotrVal,
                otros_spec: gotsVal,
                observaciones: gobsVal,
                
                inicio_marcha: getRadioValue('tinetti-inicio_marcha'),
                paso_pd_longitud: getRadioValue('tinetti-paso_pd_longitud'),
                paso_pd_altura: getRadioValue('tinetti-paso_pd_altura'),
                paso_pi_longitud: getRadioValue('tinetti-paso_pi_longitud'),
                paso_pi_altura: getRadioValue('tinetti-paso_pi_altura'),
                simetria_paso: getRadioValue('tinetti-simetria_paso'),
                continuidad_pasos: getRadioValue('tinetti-continuidad_pasos'),
                trayectoria: getRadioValue('tinetti-trayectoria'),
                tronco: getRadioValue('tinetti-tronco'),
                postura_marcha: getRadioValue('tinetti-postura_marcha'),
                total_balance_manual: sbalVal
            },
            dolor_puntos: window.activePainPins || []
        };
        return payload;
    }

    function getRadioValue(name) {
        var el = document.querySelector(`input[name="${name}"]:checked`);
        return el ? parseInt(el.value) : '';
    }

    function updateAutosaveUI(state, text) {
        var dot = document.getElementById('autosave-glow-dot');
        var txt = document.getElementById('autosave-text');
        if (!dot || !txt) return;

        txt.textContent = text;
        dot.className = 'autosave-glow-dot'; // reset
        if (state === 'saving') {
            dot.classList.add('saving');
        } else if (state === 'error') {
            dot.classList.add('error');
        }
    }

    // Server Autosave / local storage mirroring (GC-5)
    var saveTimeout = null;
    function runAutosave() {
        var payload = collectFormPayload();
        if (activePatientId) {
            localStorage.setItem(`expediente_draft_${activePatientId}`, JSON.stringify({
                timestamp: Date.now(),
                data: payload
            }));
        }

        if (saveTimeout) clearTimeout(saveTimeout);
        saveTimeout = setTimeout(function () {
            var offlineBanner = document.getElementById('wizard-offline-banner');

            if (!navigator.onLine) {
                updateAutosaveUI('error', 'Guardado localmente');
                if (offlineBanner) offlineBanner.style.display = 'inline-flex';
                return;
            }

            updateAutosaveUI('saving', 'Guardando...');
            if (offlineBanner) offlineBanner.style.display = 'none';

            if (!payload.patient.name) return;

            var url = (window.URLROOT || '') + `/dashboard/saveExpediente/${activePatientId}`;
            var csrfToken = document.querySelector('meta[name="csrf-token"]');
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken ? csrfToken.getAttribute('content') : ''
                },
                body: JSON.stringify(payload)
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.status === 'success') {
                    var now = new Date();
                    var timeStr = now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    updateAutosaveUI('saved', `Guardado a las ${timeStr}`);
                } else {
                    updateAutosaveUI('error', 'Error al guardar');
                }
            })
            .catch(function () {
                updateAutosaveUI('error', 'Error de conexión (Guardado local)');
                if (offlineBanner) offlineBanner.style.display = 'inline-flex';
            });
        }, 1000);
    }

    setupOptionChips();
    setupTAMask();

    document.querySelectorAll('.wizard-step-content').forEach(function (content) {
        content.addEventListener('scroll', function () {
            updateScrollIndicator(content);
        });
    });

    var estInput = document.getElementById('exploracion-estatura');
    var pesInput = document.getElementById('exploracion-peso');
    if (estInput) {
        estInput.addEventListener('input', updateIMCGauge);
        estInput.addEventListener('change', updateIMCGauge);
    }
    if (pesInput) {
        pesInput.addEventListener('input', updateIMCGauge);
        pesInput.addEventListener('change', updateIMCGauge);
    }

    // Attach autosave triggers to Step 1 fields on change / blur
    var inputs = [
        'patient-name', 'patient-ocupacion', 'patient-fecha-nacimiento',
        'patient-sexo', 'patient-estado-civil', 'patient-domicilio',
        'patient-tel', 'patient-cel', 'patient-familiar-responsable', 'patient-familiar-tel-cel',
        'exploracion-estatura', 'exploracion-peso', 'exploracion-ta',
        'exploracion-fc', 'exploracion-fr', 'exploracion-arcos', 'exploracion-fuerza',
        'exploracion-reflejos', 'exploracion-sensibilidad', 'exploracion-lenguaje-orientacion', 'exploracion-otros',
        'cicatriz-sitio', 'padecimiento-motivo', 'padecimiento-inicio',
        'padecimiento-evolucion', 'padecimiento-estudios', 'padecimiento-tratamientos',
        'expediente-notas-generales', 'gait-observaciones', 'gait-otros-spec'
    ];

    inputs.forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('blur', runAutosave);
            el.addEventListener('change', runAutosave);
        }
    });

    // Checkboxes click events
    var checks = [
        'cicatriz-queloide', 'cicatriz-retractil', 'cicatriz-abierta', 'cicatriz-con-adherencia', 'cicatriz-hipertrofica',
        'gait-libre', 'gait-claudicante', 'gait-con-ayuda', 'gait-espasticas', 'gait-ataxica'
    ];
    checks.forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', runAutosave);
        }
    });

    var saveBtn = document.getElementById('wizard-btn-save');
    if (saveBtn) {
        saveBtn.addEventListener('click', function () {
            runAutosave();
            closeModal();
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    // Client-side live search for patients
    var searchInput = document.getElementById('patient-live-search');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var query = (searchInput.value || '').toLowerCase().trim();
            var rows = document.querySelectorAll('#patients-table tbody tr');
            rows.forEach(function (row) {
                var text = (row.textContent || '').toLowerCase();
                row.style.display = query === '' || text.indexOf(query) !== -1 ? '' : 'none';
            });
        });
    }

    window.addEventListener('online', function () {
        var offlineBanner = document.getElementById('wizard-offline-banner');
        if (offlineBanner) offlineBanner.style.display = 'none';
        runAutosave();
    });

    window.addEventListener('offline', function () {
        var offlineBanner = document.getElementById('wizard-offline-banner');
        if (offlineBanner) offlineBanner.style.display = 'inline-flex';
        updateAutosaveUI('error', 'Guardado localmente');
    });

    // Interactive Body Map Pin Logic
    window.activePainPins = [];

    var wrappers = document.querySelectorAll('.body-map-wrapper');
    wrappers.forEach(function (wrap) {
        wrap.addEventListener('click', function (e) {
            var rect = wrap.getBoundingClientRect();
            var xPct = ((e.clientX - rect.left) / rect.width) * 100;
            var yPct = ((e.clientY - rect.top) / rect.height) * 100;
            var vista = wrap.getAttribute('data-vista') || 'anterior';

            var eva = prompt('Grado de Dolor en la Escala EVA (1 - 10):', '5');
            if (eva === null) return;
            var evaNum = parseInt(eva) || 5;
            if (evaNum < 1) evaNum = 1;
            if (evaNum > 10) evaNum = 10;

            var tipo = prompt('Tipo de Dolor (Punzante, Sordo, Urente, Opresivo):', 'Sordo');

            window.activePainPins.push({
                region: 'Punto ' + (window.activePainPins.length + 1),
                vista: vista,
                eva_nivel: evaNum,
                tipo_dolor: tipo || 'Sordo',
                notas: '',
                pos_x: xPct,
                pos_y: yPct
            });

            renderBodyMapPins();
            runAutosave();
        });
    });

    window.renderBodyMapPins = function () {
        var layerAnt = document.getElementById('pins-layer-anterior');
        var layerPost = document.getElementById('pins-layer-posterior');
        if (layerAnt) layerAnt.innerHTML = '';
        if (layerPost) layerPost.innerHTML = '';

        (window.activePainPins || []).forEach(function (pin, idx) {
            var targetLayer = pin.vista === 'posterior' ? layerPost : layerAnt;
            if (!targetLayer) return;

            var pinEl = document.createElement('div');
            pinEl.className = 'pain-pin-dot';
            pinEl.style.position = 'absolute';
            pinEl.style.left = pin.pos_x + '%';
            pinEl.style.top = pin.pos_y + '%';
            pinEl.style.transform = 'translate(-50%, -50%)';
            pinEl.style.width = '20px';
            pinEl.style.height = '20px';
            pinEl.style.borderRadius = '50%';
            pinEl.style.background = pin.eva_nivel >= 7 ? '#ef4444' : (pin.eva_nivel >= 4 ? '#f59e0b' : '#3b82f6');
            pinEl.style.color = '#ffffff';
            pinEl.style.fontSize = '10px';
            pinEl.style.fontWeight = 'bold';
            pinEl.style.display = 'flex';
            pinEl.style.alignItems = 'center';
            pinEl.style.justifyContent = 'center';
            pinEl.style.border = '2px solid #ffffff';
            pinEl.style.boxShadow = '0 2px 6px rgba(0,0,0,0.3)';
            pinEl.style.pointerEvents = 'auto';
            pinEl.style.cursor = 'pointer';
            pinEl.title = (pin.region || 'Punto') + ' (EVA: ' + pin.eva_nivel + '/10, ' + pin.tipo_dolor + ')';
            pinEl.textContent = pin.eva_nivel;

            pinEl.addEventListener('click', function (ev) {
                ev.stopPropagation();
                if (confirm('¿Eliminar este punto de dolor (EVA ' + pin.eva_nivel + ')?')) {
                    window.activePainPins.splice(idx, 1);
                    renderBodyMapPins();
                    runAutosave();
                }
            });

            targetLayer.appendChild(pinEl);
        });
    };

    var exportPdfBtn = document.getElementById('btn-export-pdf-expediente');
    if (exportPdfBtn) {
        exportPdfBtn.addEventListener('click', function () {
            if (activePatientId) {
                var url = (window.URLROOT || '') + '/dashboard/exportExpedientePdf/' + activePatientId;
                window.open(url, '_blank');
            } else {
                alert('Selecciona un expediente primero.');
            }
        });
    }
});
