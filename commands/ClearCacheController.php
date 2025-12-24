<?php
/**
 * Console controller para limpar caches
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;

/**
 * Comando para limpar todos os caches do sistema
 */
class ClearCacheController extends Controller
{
    /**
     * Limpa todos os caches (assets, runtime, sessions)
     */
    public function actionIndex()
    {
        $this->stdout("🧹 Iniciando limpeza de cache...\n");
        
        $cleared = [];
        
        // Limpar cache de runtime
        if ($this->clearRuntimeCache()) {
            $cleared[] = "Cache do runtime";
        }
        
        // Limpar assets
        if ($this->clearAssets()) {
            $cleared[] = "Assets compilados";
        }
        
        // Limpar sessões
        if ($this->clearSessions()) {
            $cleared[] = "Sessões";
        }
        
        // Limpar logs antigos (opcional)
        if ($this->clearOldLogs()) {
            $cleared[] = "Logs antigos";
        }
        
        $this->stdout("\n✅ Cache limpo com sucesso!\n");
        $this->stdout("📦 Itens limpos: " . implode(", ", $cleared) . "\n");
        $this->stdout("💡 Dica: Acesse o site para regenerar os assets automaticamente.\n");
        
        return 0;
    }
    
    /**
     * Limpa apenas o cache de runtime
     */
    public function actionRuntime()
    {
        $this->stdout("🧹 Limpando cache do runtime...\n");
        
        if ($this->clearRuntimeCache()) {
            $this->stdout("✅ Cache do runtime limpo!\n");
        } else {
            $this->stdout("❌ Erro ao limpar cache do runtime!\n");
            return 1;
        }
        
        return 0;
    }
    
    /**
     * Limpa apenas os assets
     */
    public function actionAssets()
    {
        $this->stdout("🧹 Limpando assets...\n");
        
        if ($this->clearAssets()) {
            $this->stdout("✅ Assets limpos!\n");
        } else {
            $this->stdout("❌ Erro ao limpar assets!\n");
            return 1;
        }
        
        return 0;
    }
    
    /**
     * Limpar cache do runtime
     */
    private function clearRuntimeCache()
    {
        try {
            $runtimePath = Yii::getAlias('@runtime');
            
            // Pastas para limpar
            $foldersToClean = [
                $runtimePath . '/cache',
                $runtimePath . '/HTML',
                $runtimePath . '/debug'
            ];
            
            foreach ($foldersToClean as $folder) {
                if (file_exists($folder)) {
                    FileHelper::removeDirectory($folder);
                    FileHelper::createDirectory($folder);
                }
            }
            
            return true;
        } catch (\Exception $e) {
            $this->stderr("Erro ao limpar runtime: " . $e->getMessage() . "\n");
            return false;
        }
    }
    
    /**
     * Limpar assets compilados
     */
    private function clearAssets()
    {
        try {
            $assetsPath = Yii::getAlias('@webroot/assets');
            
            if (file_exists($assetsPath)) {
                // Manter apenas o .gitignore
                $files = glob($assetsPath . '/*');
                foreach ($files as $file) {
                    if (basename($file) !== '.gitignore') {
                        if (is_dir($file)) {
                            FileHelper::removeDirectory($file);
                        } else {
                            unlink($file);
                        }
                    }
                }
            }
            
            return true;
        } catch (\Exception $e) {
            $this->stderr("Erro ao limpar assets: " . $e->getMessage() . "\n");
            return false;
        }
    }
    
    /**
     * Limpar sessões
     */
    private function clearSessions()
    {
        try {
            $sessionPath = Yii::getAlias('@runtime/session');
            
            if (file_exists($sessionPath)) {
                FileHelper::removeDirectory($sessionPath);
                FileHelper::createDirectory($sessionPath);
            }
            
            return true;
        } catch (\Exception $e) {
            $this->stderr("Erro ao limpar sessões: " . $e->getMessage() . "\n");
            return false;
        }
    }
    
    /**
     * Limpar logs antigos (mais de 7 dias)
     */
    private function clearOldLogs()
    {
        try {
            $logsPath = Yii::getAlias('@runtime/logs');
            
            if (file_exists($logsPath)) {
                $files = glob($logsPath . '/*.log');
                $weekAgo = time() - (7 * 24 * 60 * 60);
                
                foreach ($files as $file) {
                    if (filemtime($file) < $weekAgo) {
                        unlink($file);
                    }
                }
            }
            
            return true;
        } catch (\Exception $e) {
            $this->stderr("Erro ao limpar logs: " . $e->getMessage() . "\n");
            return false;
        }
    }
}