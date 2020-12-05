import isMobile from 'ismobilejs'

export default {
    /**
     * スマホ もしくは タブレットかどうかを判定する
     * スマホ もしくは タブレットだったらtrue、それ以外はfalse
     */
    isAny: function () {
        if (isMobile.any) {
            return true;
        }
        return false;
    },
    /**
     * スマホかどうかを判定する
     * スマホだったらtrue、それ以外はfalse
     */
    isMobile: function () {
        if (isMobile.phone) {
            return true;
        }
        return false;
    },
    /**
     * タブレットかどうかを判定する
     * タブレットだったらtrue、それ以外はfalse
     */
    isTablet: function () {
        if (isMobile.tablet) {
            return true;
        }
        return false;
    }
}
