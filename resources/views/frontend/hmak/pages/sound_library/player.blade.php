{{-- ===== Floating Persistent Audio Player ===== --}}
<div id="floating-audio-player" style="display: none;" class="fixed bottom-0 left-0 right-0 z-50 bg-slate-900/95 dark:bg-slate-950/95 text-white border-t border-slate-800 shadow-2xl transition-all duration-500 transform translate-y-full backdrop-blur-md">
    {{-- Audio Element --}}
    <audio id="main-audio-element" class="hidden" preload="auto"></audio>

    <div class="max-w-7xl mx-auto px-4 py-4 md:py-5 flex flex-col md:flex-row items-center justify-between gap-4">
        
        {{-- Left Side: Track Details --}}
        <div class="flex items-center gap-3 w-full md:w-1/3">
            <div class="w-12 h-12 rounded-xl bg-slate-800 overflow-hidden border border-slate-700 flex-shrink-0 relative group">
                <img id="player-avatar" src="" alt="avatar" class="w-full h-full object-cover hidden">
                <div id="player-avatar-placeholder" class="w-full h-full flex items-center justify-center text-slate-400">
                    <span class="material-symbols-outlined text-2xl">music_note</span>
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <h4 id="player-track-name" class="font-bold text-sm text-slate-100 truncate">اسم المقطع الصوتي</h4>
                <p id="player-author-name" class="text-xs text-slate-400 truncate mt-0.5">المؤلف / مقدم البرنامج</p>
            </div>
        </div>

        {{-- Center Side: Controls & Timeline --}}
        <div class="flex flex-col items-center gap-2.5 w-full md:w-1/3">
            <div class="flex items-center gap-4">
                {{-- Rewind 10s --}}
                <button id="player-btn-rewind" class="text-slate-400 hover:text-white transition-colors focus:outline-none" title="رجوع 10 ثوانٍ">
                    <span class="material-symbols-outlined text-2xl">replay_10</span>
                </button>
                {{-- Play / Pause --}}
                <button id="player-btn-play-pause" class="w-11 h-11 bg-primary hover:bg-sky-500 text-white rounded-full flex items-center justify-center shadow-lg transition-transform active:scale-95 focus:outline-none">
                    <span class="material-symbols-outlined text-2xl" id="play-pause-icon">play_arrow</span>
                </button>
                {{-- Forward 10s --}}
                <button id="player-btn-forward" class="text-slate-400 hover:text-white transition-colors focus:outline-none" title="تقدم 10 ثوانٍ">
                    <span class="material-symbols-outlined text-2xl">forward_10</span>
                </button>
            </div>
            
            {{-- Progress timeline --}}
            <div class="flex items-center gap-3 w-full" id="player-timeline-wrapper">
                <span id="player-time-current" class="text-[10px] text-slate-400 font-semibold w-10 text-left">00:00</span>
                <div class="relative flex-grow h-1.5 bg-slate-800 rounded-full cursor-pointer group" id="player-timeline-container">
                    <div id="player-timeline-progress" class="absolute left-0 top-0 bottom-0 bg-primary rounded-full w-0 transition-all duration-75"></div>
                    <div id="player-timeline-handle" class="absolute top-1/2 -translate-y-1/2 w-3 h-3 bg-white border border-primary rounded-full shadow-md scale-0 group-hover:scale-100 transition-transform pointer-events-none" style="left: 0%;"></div>
                </div>
                <span id="player-time-duration" class="text-[10px] text-slate-400 font-semibold w-10 text-right">00:00</span>
            </div>
        </div>

        {{-- Right Side: Volume & Options --}}
        <div class="flex items-center justify-end gap-4 w-full md:w-1/3">
            {{-- Live stream badge --}}
            <span id="player-live-badge" class="hidden items-center gap-1 px-3 py-1 rounded-full bg-red-600 text-white text-[10px] font-extrabold animate-pulse uppercase tracking-wider">
                <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                مباشر
            </span>
            
            {{-- Mute / Volume --}}
            <div class="flex items-center gap-2 group/volume">
                <button id="player-btn-volume" class="text-slate-405 hover:text-white transition-colors focus:outline-none" title="كتم/تشغيل الصوت">
                    <span class="material-symbols-outlined text-xl" id="volume-icon">volume_up</span>
                </button>
                <input type="range" id="player-volume-slider" min="0" max="1" step="0.05" value="0.8" class="w-16 md:w-20 accent-primary h-1 bg-slate-800 rounded-lg appearance-none cursor-pointer">
            </div>

            {{-- Share Track --}}
            <button id="player-btn-share" class="text-slate-400 hover:text-primary transition-colors p-1.5 rounded-lg hover:bg-slate-800 focus:outline-none" title="مشاركة المقطع الصوتي">
                <span class="material-symbols-outlined text-lg">share</span>
            </button>

            {{-- Close Player --}}
            <button id="player-btn-close" class="text-slate-400 hover:text-red-400 transition-colors p-1.5 rounded-lg hover:bg-slate-800 focus:outline-none" title="إغلاق المشغل">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const player = document.getElementById('floating-audio-player');
    const audio = document.getElementById('main-audio-element');
    const playPauseBtn = document.getElementById('player-btn-play-pause');
    const playPauseIcon = document.getElementById('play-pause-icon');
    const rewindBtn = document.getElementById('player-btn-rewind');
    const forwardBtn = document.getElementById('player-btn-forward');
    const timeCurrent = document.getElementById('player-time-current');
    const timeDuration = document.getElementById('player-time-duration');
    const timelineWrapper = document.getElementById('player-timeline-wrapper');
    const timelineContainer = document.getElementById('player-timeline-container');
    const timelineProgress = document.getElementById('player-timeline-progress');
    const timelineHandle = document.getElementById('player-timeline-handle');
    const volumeBtn = document.getElementById('player-btn-volume');
    const volumeIcon = document.getElementById('volume-icon');
    const volumeSlider = document.getElementById('player-volume-slider');
    const shareBtn = document.getElementById('player-btn-share');
    const closeBtn = document.getElementById('player-btn-close');
    const liveBadge = document.getElementById('player-live-badge');
    
    const playerAvatar = document.getElementById('player-avatar');
    const playerAvatarPlaceholder = document.getElementById('player-avatar-placeholder');
    const playerTrackName = document.getElementById('player-track-name');
    const playerAuthorName = document.getElementById('player-author-name');

    let currentPlayingBtn = null;
    let savedVolume = parseFloat(localStorage.getItem('hmak_player_volume') || '0.8');
    let isLive = false;
    let isDraggingTimeline = false;
    let dragTime = 0;
    let currentShareUrl = '';

    // Helper: Format Time in MM:SS
    function formatTime(secs) {
        if (isNaN(secs) || !isFinite(secs)) return '00:00';
        const m = Math.floor(secs / 60).toString().padStart(2, '0');
        const s = Math.floor(secs % 60).toString().padStart(2, '0');
        return `${m}:${s}`;
    }

    // Load & Play track
    window.playTrack = function(url, name, author, avatar, type, buttonEl, directShareUrl) {
        if (!url) return;

        // Stop and release previous audio stream/socket to prevent simultaneous playback
        audio.pause();
        audio.src = '';
        audio.load();

        // Reset previous buttons
        resetAllTrackButtons();

        currentPlayingBtn = buttonEl;
        isLive = (type === 'live');

        // Set Audio source
        audio.src = url;
        audio.load();

        // Update details UI
        playerTrackName.textContent = name || 'بدون عنوان';
        playerAuthorName.textContent = author || 'مؤلف غير معروف';

        if (avatar) {
            playerAvatar.src = avatar;
            playerAvatar.classList.remove('hidden');
            playerAvatarPlaceholder.classList.add('hidden');
        } else {
            playerAvatar.classList.add('hidden');
            playerAvatarPlaceholder.classList.remove('hidden');
        }

        // Handle live stream badge and seek bar visibility
        if (isLive) {
            liveBadge.classList.remove('hidden');
            liveBadge.classList.add('inline-flex');
            timelineWrapper.classList.add('invisible');
        } else {
            liveBadge.classList.add('hidden');
            liveBadge.classList.remove('inline-flex');
            timelineWrapper.classList.remove('invisible');
        }

        // Show player (slide up)
        player.style.display = 'block';
        setTimeout(() => {
            player.classList.remove('translate-y-full');
        }, 50);

        // Resolve share URL
        if (buttonEl) {
            currentShareUrl = buttonEl.getAttribute('data-share-url') || '';
        } else if (directShareUrl) {
            currentShareUrl = directShareUrl;
        } else {
            currentShareUrl = '';
        }

        // Save state to localStorage
        localStorage.setItem('hmak_player_url', url);
        localStorage.setItem('hmak_player_title', name || '');
        localStorage.setItem('hmak_player_author', author || '');
        localStorage.setItem('hmak_player_avatar', avatar || '');
        localStorage.setItem('hmak_player_type', type || '');
        localStorage.setItem('hmak_player_time', '0');
        localStorage.setItem('hmak_player_share_url', currentShareUrl);

        // Queue logic: If playing from a list button on page, rebuild the queue
        if (buttonEl) {
            const triggers = Array.from(document.querySelectorAll('.play-track-trigger'));
            const currentIndex = triggers.indexOf(buttonEl);
            if (currentIndex !== -1) {
                const queue = triggers.map(t => ({
                    url: t.getAttribute('data-src'),
                    name: t.getAttribute('data-title'),
                    author: t.getAttribute('data-author'),
                    avatar: t.getAttribute('data-avatar'),
                    type: t.getAttribute('data-type'),
                    shareUrl: t.getAttribute('data-share-url') || ''
                }));
                localStorage.setItem('hmak_player_queue', JSON.stringify(queue));
                localStorage.setItem('hmak_player_queue_index', currentIndex.toString());
            }
        }

        // Attempt playback
        const playPromise = audio.play();
        if (playPromise !== undefined) {
            playPromise.then(() => {
                updatePlayPauseState(true);
            }).catch(error => {
                console.error("Playback failed: ", error);
                updatePlayPauseState(false);
            });
        }
    };

    // Sync button state from outside router
    window.syncPlayingButton = function(buttonEl, isPlaying) {
        resetAllTrackButtons();
        currentPlayingBtn = buttonEl;
        updatePlayPauseState(isPlaying);
    };

    // Toggle Play/Pause
    function togglePlayPause() {
        if (audio.paused) {
            audio.play().then(() => {
                updatePlayPauseState(true);
            }).catch(err => console.error(err));
        } else {
            audio.pause();
            updatePlayPauseState(false);
        }
    }

    // Update play/pause icon state
    function updatePlayPauseState(isPlaying) {
        if (isPlaying) {
            playPauseIcon.textContent = 'pause';
            localStorage.setItem('hmak_player_playing', 'true');
            if (currentPlayingBtn) {
                const icon = currentPlayingBtn.querySelector('.track-btn-icon');
                if (icon) icon.textContent = 'pause_circle';
                currentPlayingBtn.classList.add('bg-primary/20', 'border-primary');
            }
        } else {
            playPauseIcon.textContent = 'play_arrow';
            localStorage.setItem('hmak_player_playing', 'false');
            if (currentPlayingBtn) {
                const icon = currentPlayingBtn.querySelector('.track-btn-icon');
                if (icon) icon.textContent = 'play_circle';
            }
        }
    }

    // Reset all track buttons on the list
    function resetAllTrackButtons() {
        document.querySelectorAll('.play-track-trigger').forEach(btn => {
            btn.classList.remove('bg-primary/20', 'border-primary');
            const icon = btn.querySelector('.track-btn-icon');
            if (icon) icon.textContent = 'play_circle';
        });
    }

    // Time Update event
    audio.addEventListener('timeupdate', () => {
        if (isLive || isDraggingTimeline) return;
        
        const curr = audio.currentTime;
        const dur = audio.duration;

        timeCurrent.textContent = formatTime(curr);
        
        // Save current play time to localStorage (lightweight)
        localStorage.setItem('hmak_player_time', curr);

        if (dur && isFinite(dur)) {
            timeDuration.textContent = formatTime(dur);
            const pct = (curr / dur) * 100;
            timelineProgress.style.width = `${pct}%`;
            timelineHandle.style.left = `${pct}%`;
        }
    });

    // Metadata Loaded event
    audio.addEventListener('loadedmetadata', () => {
        if (isLive) {
            timeCurrent.textContent = '00:00';
            timeDuration.textContent = '00:00';
        } else {
            timeDuration.textContent = formatTime(audio.duration);
        }
    });

    // Track ended
    audio.addEventListener('ended', () => {
        updatePlayPauseState(false);
        
        // Autoplay next track from queue
        const queueStr = localStorage.getItem('hmak_player_queue');
        let currentIndex = parseInt(localStorage.getItem('hmak_player_queue_index') || '-1');
        
        if (queueStr && currentIndex !== -1) {
            const queue = JSON.parse(queueStr);
            if (currentIndex < queue.length - 1) {
                const nextIndex = currentIndex + 1;
                const nextTrack = queue[nextIndex];
                
                // Update queue index in storage
                localStorage.setItem('hmak_player_queue_index', nextIndex.toString());
                
                // Check if the button element is on the current page to highlight it
                const matchingTrigger = document.querySelector(`.play-track-trigger[data-src="${nextTrack.url}"]`);
                
                // Play it!
                window.playTrack(nextTrack.url, nextTrack.name, nextTrack.author, nextTrack.avatar, nextTrack.type, matchingTrigger, nextTrack.shareUrl);
                return;
            }
        }

        // Default reset if queue ends
        timelineProgress.style.width = '0%';
        timelineHandle.style.left = '0%';
        timeCurrent.textContent = '00:00';
        localStorage.setItem('hmak_player_time', '0');
        localStorage.setItem('hmak_player_playing', 'false');
    });

    // Play/Pause button click
    playPauseBtn.addEventListener('click', togglePlayPause);

    // Skip controls (Rewind / Forward 10s)
    rewindBtn.addEventListener('click', () => {
        if (isLive) return;
        audio.currentTime = Math.max(0, audio.currentTime - 10);
    });

    forwardBtn.addEventListener('click', () => {
        if (isLive) return;
        audio.currentTime = Math.min(audio.duration || 0, audio.currentTime + 10);
    });

    function getTimelinePct(e) {
        const rect = timelineContainer.getBoundingClientRect();
        let clientX = e.clientX;
        if (e.touches && e.touches.length > 0) {
            clientX = e.touches[0].clientX;
        }
        const clickX = clientX - rect.left;
        const width = rect.width;
        let pct = clickX / width;
        return Math.max(0, Math.min(1, pct));
    }

    function updateTimelineVisual(pct) {
        if (!audio.duration || !isFinite(audio.duration)) return;
        dragTime = pct * audio.duration;
        timeCurrent.textContent = formatTime(dragTime);
        timelineProgress.style.width = `${pct * 100}%`;
        timelineHandle.style.left = `${pct * 100}%`;
    }

    // Seek / Timeline click
    timelineContainer.addEventListener('click', (e) => {
        if (isLive || !audio.duration || !isFinite(audio.duration)) return;
        const pct = getTimelinePct(e);
        audio.currentTime = pct * audio.duration;
    });

    // Mouse drag seeking
    timelineContainer.addEventListener('mousedown', (e) => {
        if (isLive || !audio.duration || !isFinite(audio.duration)) return;
        isDraggingTimeline = true;
        const pct = getTimelinePct(e);
        updateTimelineVisual(pct);
    });

    window.addEventListener('mousemove', (e) => {
        if (!isDraggingTimeline) return;
        const pct = getTimelinePct(e);
        updateTimelineVisual(pct);
    });

    window.addEventListener('mouseup', () => {
        if (isDraggingTimeline) {
            isDraggingTimeline = false;
            audio.currentTime = dragTime;
        }
    });

    // Touch drag seeking (mobile)
    timelineContainer.addEventListener('touchstart', (e) => {
        if (isLive || !audio.duration || !isFinite(audio.duration)) return;
        isDraggingTimeline = true;
        const pct = getTimelinePct(e);
        updateTimelineVisual(pct);
    }, { passive: true });

    timelineContainer.addEventListener('touchmove', (e) => {
        if (!isDraggingTimeline) return;
        const pct = getTimelinePct(e);
        updateTimelineVisual(pct);
    }, { passive: true });

    timelineContainer.addEventListener('touchend', () => {
        if (isDraggingTimeline) {
            isDraggingTimeline = false;
            audio.currentTime = dragTime;
        }
    });

    // Volume controls
    volumeSlider.addEventListener('input', (e) => {
        const val = parseFloat(e.target.value);
        audio.volume = val;
        savedVolume = val;
        localStorage.setItem('hmak_player_volume', val);
        updateVolumeIcon(val);
    });

    volumeBtn.addEventListener('click', () => {
        if (audio.volume > 0) {
            savedVolume = audio.volume;
            audio.volume = 0;
            volumeSlider.value = 0;
            localStorage.setItem('hmak_player_volume', 0);
            updateVolumeIcon(0);
        } else {
            audio.volume = savedVolume;
            volumeSlider.value = savedVolume;
            localStorage.setItem('hmak_player_volume', savedVolume);
            updateVolumeIcon(savedVolume);
        }
    });

    function updateVolumeIcon(val) {
        if (val === 0) {
            volumeIcon.textContent = 'volume_off';
        } else if (val < 0.4) {
            volumeIcon.textContent = 'volume_down';
        } else {
            volumeIcon.textContent = 'volume_up';
        }
    }

    // Set initial volume
    audio.volume = savedVolume;
    volumeSlider.value = savedVolume;
    updateVolumeIcon(savedVolume);

    // Close Player
    closeBtn.addEventListener('click', () => {
        audio.pause();
        updatePlayPauseState(false);
        player.classList.add('translate-y-full');
        setTimeout(() => {
            if (player.classList.contains('translate-y-full')) {
                player.style.display = 'none';
            }
        }, 500);
        resetAllTrackButtons();
        
        // Clear track storage keys
        localStorage.removeItem('hmak_player_url');
        localStorage.removeItem('hmak_player_title');
        localStorage.removeItem('hmak_player_author');
        localStorage.removeItem('hmak_player_avatar');
        localStorage.removeItem('hmak_player_type');
        localStorage.removeItem('hmak_player_playing');
        localStorage.removeItem('hmak_player_time');
        localStorage.removeItem('hmak_player_share_url');
    });

    // Attach click listeners to lists dynamically loaded on page
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('.play-track-trigger');
        if (trigger) {
            e.preventDefault();
            
            const url = trigger.getAttribute('data-src');
            const name = trigger.getAttribute('data-title');
            const author = trigger.getAttribute('data-author');
            const avatar = trigger.getAttribute('data-avatar');
            const type = trigger.getAttribute('data-type');
            
            // If they click the currently playing button, toggle play/pause instead of restarting
            if (currentPlayingBtn === trigger) {
                togglePlayPause();
            } else {
                window.playTrack(url, name, author, avatar, type, trigger);
            }
        }
    });

    // ===== Persisted State Recovery on Page Load =====
    const storedUrl = localStorage.getItem('hmak_player_url');
    const storedTitle = localStorage.getItem('hmak_player_title');
    const storedAuthor = localStorage.getItem('hmak_player_author');
    const storedAvatar = localStorage.getItem('hmak_player_avatar');
    const storedType = localStorage.getItem('hmak_player_type');
    const storedPlaying = localStorage.getItem('hmak_player_playing');
    const storedTime = parseFloat(localStorage.getItem('hmak_player_time') || '0');
    const storedShareUrl = localStorage.getItem('hmak_player_share_url');

    if (storedUrl) {
        isLive = (storedType === 'live');
        audio.src = storedUrl;
        audio.load();

        if (storedShareUrl) {
            currentShareUrl = storedShareUrl;
        }

        // Update UI
        playerTrackName.textContent = storedTitle || 'بدون عنوان';
        playerAuthorName.textContent = storedAuthor || 'مؤلف غير معروف';

        if (storedAvatar) {
            playerAvatar.src = storedAvatar;
            playerAvatar.classList.remove('hidden');
            playerAvatarPlaceholder.classList.add('hidden');
        } else {
            playerAvatar.classList.add('hidden');
            playerAvatarPlaceholder.classList.remove('hidden');
        }

        if (isLive) {
            liveBadge.classList.remove('hidden');
            liveBadge.classList.add('inline-flex');
            timelineWrapper.classList.add('invisible');
        } else {
            liveBadge.classList.add('hidden');
            liveBadge.classList.remove('inline-flex');
            timelineWrapper.classList.remove('invisible');
        }

        // Set time offset once loaded
        if (storedTime > 0 && !isLive) {
            audio.addEventListener('loadedmetadata', () => {
                audio.currentTime = storedTime;
            }, { once: true });
        }

        // Slide player up
        player.style.display = 'block';
        setTimeout(() => {
            player.classList.remove('translate-y-full');
        }, 50);

        // Look for matching trigger button on this page to hook highlight
        const matchingTrigger = document.querySelector(`.play-track-trigger[data-src="${storedUrl}"]`);
        if (matchingTrigger) {
            currentPlayingBtn = matchingTrigger;
        }

        // Play if previously active
        if (storedPlaying === 'true') {
            const playPromise = audio.play();
            if (playPromise !== undefined) {
                playPromise.then(() => {
                    updatePlayPauseState(true);
                }).catch(error => {
                    console.log("Autoplay was prevented by browser policy. Click Play to resume.");
                    updatePlayPauseState(false);
                });
            }
        } else {
            updatePlayPauseState(false);
        }
    }

    // ===== Share Link Button & Toast logic =====
    shareBtn.addEventListener('click', () => {
        const urlToShare = currentShareUrl || window.location.href;
        navigator.clipboard.writeText(urlToShare).then(() => {
            showShareToast();
        }).catch(err => {
            console.error('Could not copy share URL: ', err);
        });
    });

    function showShareToast() {
        const existingToast = document.getElementById('share-success-toast');
        if (existingToast) {
            existingToast.remove();
        }

        const toast = document.createElement('div');
        toast.id = 'share-success-toast';
        toast.className = 'fixed bottom-24 left-5 z-[200000] bg-slate-900/90 dark:bg-slate-950/90 text-white text-xs font-bold px-5 py-3 rounded-2xl shadow-xl border border-white/10 flex items-center gap-2.5 backdrop-blur-md transition-all duration-300 transform translate-y-10 opacity-0';
        toast.style.direction = 'rtl';
        toast.innerHTML = `
            <span class="material-symbols-outlined text-emerald-400 text-lg">check_circle</span>
            <span>تم نسخ رابط مشاركة المقطع الصوتي بنجاح!</span>
        `;
        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-y-10', 'opacity-0');
        }, 50);

        // Hide and remove
        setTimeout(() => {
            toast.classList.add('translate-y-10', 'opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    // ===== Autoplay Shared Track Parser =====
    function checkAndPlaySharedTrack() {
        const urlParams = new URLSearchParams(window.location.search);
        const playTrackId = urlParams.get('play_track_id');
        if (playTrackId) {
            const trigger = document.querySelector(`.play-track-trigger[data-id="${playTrackId}"]`);
            if (trigger) {
                if (currentPlayingBtn === trigger && !audio.paused) {
                    return;
                }

                const url = trigger.getAttribute('data-src');
                const name = trigger.getAttribute('data-title');
                const author = trigger.getAttribute('data-author');
                const avatar = trigger.getAttribute('data-avatar');
                const type = trigger.getAttribute('data-type');
                const shareUrl = trigger.getAttribute('data-share-url') || '';

                window.playTrack(url, name, author, avatar, type, trigger, shareUrl);
            }
        }
    }

    // Initialize Autoplay checks on page load
    checkAndPlaySharedTrack();

    // Hook Autoplay checks to PJAX page content swaps
    document.addEventListener('pjax:end', () => {
        checkAndPlaySharedTrack();
    });
});
</script>
