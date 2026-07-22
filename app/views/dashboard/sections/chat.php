<header class="toolbar">
    <div class="tol-left"><div class="date-title"><span>Mensajes</span></div></div>
</header>
<section class="crm-content chat-reference">
<aside class="chat-list ref">
        <?php
            $avatarColors = ['#E8A0AC', '#00a29a', '#6C63FF', '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7'];
        ?>
        <?php foreach (($data['chat_contacts'] ?? []) as $contact) : ?>
            <a class="chat-item" href="<?php echo URLROOT; ?>/dashboard/chat?with=<?php echo (int)$contact->id; ?>">
                <div class="chat-avatar-photo" style="background:<?php echo $avatarColors[$contact->id % count($avatarColors)]; ?>;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;border-radius:50%;"><?php echo strtoupper(substr($contact->name, 0, 1)); ?></div>
                <div class="chat-meta">
                    <div class="chat-name"><?php echo htmlspecialchars($contact->name); ?></div>
                    <div class="chat-last"><?php echo htmlspecialchars($contact->last_message ?? $contact->role); ?></div>
                </div>
            </a>
        <?php endforeach; ?>
    </aside>
    <?php if (!empty($data['chat_with'])) : ?>
        <div class="chat-window-live">
            <div class="chat-messages">
                <?php foreach (($data['chat_messages'] ?? []) as $message) : ?>
                    <div class="chat-row <?php echo ((int)$message->sender_id === (int)$_SESSION['user_id']) ? 'own' : ''; ?>">
                        <div class="chat-avatar-mini" style="background:<?php echo $avatarColors[$message->sender_id % count($avatarColors)]; ?>;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:11px;border-radius:50%;"><?php echo strtoupper(substr($message->sender_name, 0, 1)); ?></div>
                        <div class="chat-bubble-live">
                            <strong><?php echo htmlspecialchars($message->sender_name); ?>:</strong>
                            <?php echo htmlspecialchars($message->message); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <form class="chat-send-form" action="<?php echo URLROOT; ?>/dashboard/chat" method="post">
                <?php csrfField(); ?>
                <input type="hidden" name="receiver_id" value="<?php echo (int)$data['chat_with']; ?>">
                <input type="text" name="message" placeholder="Escribe un mensaje..." required>
                <button type="submit" class="btn-configurar">Enviar</button>
            </form>
        </div>
    <?php else : ?>
        <div class="chat-empty">
            <div class="chat-empty-icon"><i class="far fa-comment-alt"></i></div>
            <div>Selecciona un chat para comenzar</div>
        </div>
    <?php endif; ?>
</section>
