<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use App\Http\Middleware\CheckUserRole; // Import the middleware

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Kernel $kernel): void
    {
        // Register middleware
        // $kernel->appendMiddlewareToGroup('web', CheckUserRole::class);
        
        // Prevent Symfony Mime from crashing when php_fileinfo is disabled
        if (class_exists(\Symfony\Component\Mime\MimeTypes::class)) {
            \Symfony\Component\Mime\MimeTypes::getDefault()->registerGuesser(new class implements \Symfony\Component\Mime\MimeTypeGuesserInterface {
                public function isGuesserSupported(): bool {
                    return true;
                }
                
                public function guessMimeType(string $path): ?string {
                    try {
                        if (request()) {
                            $files = request()->allFiles();
                            $matchingFile = $this->findFileByPath($files, $path);
                            if ($matchingFile) {
                                return $matchingFile->getClientMimeType();
                            }
                        }
                    } catch (\Exception $e) {
                        // Fail silently if request is not available
                    }
                    return null;
                }

                private function findFileByPath($files, $path) {
                    foreach ($files as $file) {
                        if (is_array($file)) {
                            $found = $this->findFileByPath($file, $path);
                            if ($found) {
                                return $found;
                            }
                        } elseif ($file instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                            if ($file->getPathname() === $path) {
                                return $file;
                            }
                        }
                    }
                    return null;
                }
            });
        }
        
        view()->composer(['frontend.hmak.body.header', 'frontend.hmak.body.footer'], function ($view) {
            $view->with('newsCategories', \App\Models\NewsCategory::latest()->get());
        });
    }
}
